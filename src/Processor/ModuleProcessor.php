<?php

/**
 * Part of the Antares package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Module
 * @version    0.9.2
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Modules\SampleModule\Processor;

use Antares\Modules\SampleModule\Events\ItemCreated;
use Antares\Modules\SampleModule\Events\ItemDeleted;
use Antares\Modules\SampleModule\Events\ItemNotCreated;
use Antares\Modules\SampleModule\Events\ItemNotDeleted;
use Antares\Modules\SampleModule\Events\ItemNotUpdated;
use Antares\Modules\SampleModule\Events\ItemUpdated;
use Antares\Modules\SampleModule\Http\Repositories\ModuleRepository;
use Antares\Modules\SampleModule\Http\Presenters\ModulePresenter;
use Antares\Modules\SampleModule\Http\Breadcrumb\ItemsBreadcrumb;
use Antares\Contracts\Html\Form\Grid as FormGrid;
use Antares\Contracts\Html\Form\Fieldset;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;
use Antares\Modules\SampleModule\Model\ModuleRow;
use Illuminate\Support\Facades\DB;
use Antares\Model\User;

class ModuleProcessor
{

    /**
     * Instancja repozytorium
     *
     * @var ModuleRepository
     */
    protected $repository;

    /**
     * Instancja presentera
     *
     * @var ModulePresenter
     */
    protected $presenter;

    /**
     * Breadcrumbs instance
     *
     * @var ItemsBreadcrumb
     */
    protected $breadcrumb;

    /**
     * ModuleProcessor constructor.
     * @param ItemsBreadcrumb $breadcrumb
     */
    public function __construct(ItemsBreadcrumb $breadcrumb)
    {
        $this->breadcrumb = $breadcrumb;
    }

    /**
     * Obsługa index action
     */
    public function index()
    {
        $data = $this->repository->findAll();
        return $this->presenter->index($data);
    }

    /**
     * Obsługa formularza
     * 
     * @return array
     */
    public function create()
    {
        $model = new ModuleRow();
        $form  = $this->form($model);
        if (app('request')->isMethod('post')) {
            if (!$form->isValid()) {
                return ['errors' => $form->getMessageBag()];
            }
        }
        return ['form' => $form];
    }

    /**
     * Generowanie nowego obiektu formularza
     * 
     * @param Model $model
     * @return \Antares\Html\Form\FormBuilder
     */
    protected function form(Model $model)
    {
        $this->breadcrumb->onItem($model);
        return app('antares.form')->of('awesone-module-form', function(FormGrid $form) use($model) {

                    $form->name('My Awesome Module Form');
                    $form->resourced('antares::sample_module/index', $model);
                    $form->fieldset(function (Fieldset $fieldset) use($model) {
                        $fieldset->legend('Fieldset');
                        if (!auth()->user()->hasRoles('member')) {
                            if (!is_null($uid = from_route('uid'))) {
                                $model->user_id = $uid;
                            }
                            $fieldset->control('select', 'user')
                                    ->label(trans('antares/sample_module::form.user_select'))
                                    ->options(function() {
                                        return User::members()
                                                ->select([DB::raw('concat(firstname," ",lastname) as name'), 'id'])
                                                ->orderBy('firstname', 'asc')
                                                ->orderBy('lastname', 'desc')
                                                ->get()
                                                ->map(function($option) {
                                                    return ['id' => $option->id, 'title' => '#' . $option->id . ' ' . $option->name];
                                                })->pluck('title', 'id');
                                    })
                                    ->attributes(['data-selectar--search' => true, 'data-placeholder' => 'testowanie'])
                                    ->help('Select user to assign new item. This field is required.')
                                    ->fieldClass('input-field--icon')
                                    ->prepend('<span class = "input-field__icon"><i class="zmdi zmdi-search"></i></span>')
                                    ->value($model->user_id);
                        }


                        $fieldset->control('input:text', 'name')
                                ->label(trans('antares/sample_module::form.name'))
                                ->help('Name of new item. This field is required.');


                        $fieldset->control('select', 'field_1')
                                ->label(trans('antares/sample_module::form.field_1'))
                                ->options(self::getOptions())
                                ->help('Select first option of an item. This field is optional.');

                        $fieldset->control('input:checkbox', 'field_2')
                                ->label(trans('antares/sample_module::form.field_2'))
                                ->value(1)
                                ->checked($model->exists ? array_get($model->value, 'field_2', false) : false)
                                ->help('Select second option of an item. This field is optional.');

                        $fieldset->control('button', 'cancel')
                                ->field(function() {
                                    return app('html')->link(handles("antares::sample_module/index"), trans('antares/foundation::label.cancel'), ['class' => 'btn btn--md btn--default mdl-button mdl-js-button']);
                                });

                        $fieldset->control('button', 'button')
                                ->attributes(['type' => 'submit', 'class' => 'btn btn-primary'])
                                ->value(trans('antares/foundation::label.save_changes'));
                    });


                    $form->rules(['name' => 'required']);
                });
    }

    /**
     * Gest select field options
     * 
     * @return array
     */
    public static function getOptions()
    {
        return [1 => 'Option 1', 2 => 'Option 2'];
    }

    /**
     * When stores form fields in database
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $input      = Input::all();
        /* @var $user User */
        $user       = auth()->user();
        $attributes = [
            'user_id' => $user->hasRoles('member') ? $user->id : array_get($input, 'user'),
            'name'    => array_get($input, 'name'),
            'value'   => array_only($input, ['field_1', 'field_2'])
        ];

        $model = new ModuleRow($attributes);
        $form  = $this->form($model);
        if (!$form->isValid()) {
            return redirect_with_errors(handles('antares::sample_module/index/create'), $form->getMessageBag());
        }
        if (!$model->save()) {
            event(new ItemNotCreated($user, $model));

            return redirect_with_message(handles('antares::sample_module/index'), trans('antares/sample_module::messages.save_error'), 'error');
        }

        event(new ItemCreated($user, $model));

        return redirect_with_message(handles('antares::sample_module/index'), trans('antares/sample_module::messages.save_success'), 'success');
    }

    /**
     * When updates form fields in database
     * 
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        /* @var $model ModuleRow */
        $model = ModuleRow::withoutGlobalScopes()->findOrFail($id);
        if (!request()->isMethod('put')) {
            $form = $this->form($model);
        } else {
            $input = Input::all();
            /* @var $user User */
            $user  = auth()->user();

            if (!$user->hasRoles('member')) {
                $model->user_id = array_get($input, 'user');
            }
            $model->name  = array_get($input, 'name');
            $model->value = array_only($input, ['field_1', 'field_2']);
            $form         = $this->form($model);

            if (!$form->isValid()) {
                return redirect_with_errors(handles('antares::sample_module/index/' . $id . '/edit'), $form->getMessageBag());
            }

            if (!$model->save()) {
                event(new ItemNotUpdated($user, $model));

                return redirect_with_message(handles('antares::sample_module/index'), trans('antares/sample_module::messages.update_error'), 'error');
            }

            event(new ItemUpdated($user, $model));

            return redirect_with_message(handles('antares::sample_module/index'), trans('antares/sample_module::messages.update_success'), 'success');
        }

        return view('antares/sample_module::admin.module.create', ['form' => $form]);
    }

    /**
     * When deletes item
     * 
     * @param mixed $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $builder = ModuleRow::withoutGlobalScopes();

        /* @var $user User */
        $user = auth()->user();

        if (auth()->user()->hasRoles('member')) {
            $builder->where(['user_id' => auth()->user()->id]);
        }

        /* @var $model ModuleRow */
        $model = $builder->findOrFail($id);
        $name  = $model->name;

        if ($model->delete()) {
            event(new ItemNotDeleted($user, $model));

            return redirect_with_message(handles('antares::sample_module/index'), trans('antares/sample_module::messages.item_has_been_deleted', ['name' => $name]), 'success');
        }
        event(new ItemDeleted($user, $model));

        return redirect_with_message(handles('antares::sample_module/index'), trans('antares/sample_module::messages.item_has_not_been_deleted', ['name' => $name]), 'error');
    }

}
