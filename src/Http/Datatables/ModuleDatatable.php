<?php

/**
 * Part of the Antares Project package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Module
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares Project
 * @link       http://antaresproject.io
 */

namespace Antares\SampleModule\Http\Datatables;

use Antares\SampleModule\Processor\ModuleProcessor;
use Antares\Customfields\Filter\SecondOptionFilter;
use Antares\Customfields\Filter\FirstOptionFilter;
use Antares\Datatables\Services\DataTable;
use Antares\SampleModule\Model\ModuleRow;
use Illuminate\Support\Facades\Event;
use Antares\Support\Facades\HTML;

class ModuleDatatable extends DataTable
{

    /**
     * User identifier
     *
     * @var mixed 
     */
    protected $userId = null;

    /**
     * Default quick search settings
     *
     * @var String
     */
    protected $search = [
        'view'     => 'antares/sample_module::admin.partials._search',
        'category' => 'Module'
    ];

    /**
     * Datatable filters
     *
     * @var array
     */
    protected $filters = [
        FirstOptionFilter::class,
        SecondOptionFilter::class,
    ];

    /**
     * Zapytanie na podstawie którego generowane są dane w tabeli (dataprovider)
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        if (!auth()->guest() && auth()->user()->hasRoles('member')) {
            $this->userId = auth()->user()->id;
        }

        $query = ModuleRow::withoutGlobalScopes()->select(['id', 'name', 'user_id', 'value'])->with('user');

        if (!is_null($this->userId)) {
            $query->where('user_id', $this->userId);
        }
        Event::listen('datatables.order.description', function($query, $direction) {
            $query->orderBy('description', $direction)->orderBy('name', 'desc');
        });
        return $query;
    }

    /**
     * User id setter
     * 
     * @param mixed $id
     * @return \Antares\Logger\Widgets\ItemsWidget
     */
    public function setUser($id)
    {
        $this->userId = $id;
        return $this;
    }

    /**
     * Ustawienia parametrów poszczególnych kolumn 
     */
    public function ajax()
    {
        $builder = $this->prepare()
                ->filterColumn('field_1', function($query, $keyword) {
                    $keywordLower = mb_strtolower($keyword);
                    $keywordUpper = mb_strtoupper($keyword);
                    return $query->where('value', 'like', "%$keywordLower%")->orWhere('value', 'like', "%$keywordUpper%");
                })
                ->filterColumn('field_2', function($query, $keyword) {
            $keywordLower = mb_strtolower($keyword);
            $keywordUpper = mb_strtoupper($keyword);
            return $query->where('value', 'like', "%$keywordLower%")->orWhere('value', 'like', "%$keywordUpper%");
        });
        if (!auth()->guest() && !auth()->user()->hasRoles('member')) {
            $builder->editColumn('user_id', function($row) {
                $user = $row->user;
                return is_null($user) ? '---' : HTML::link(handles('antares/foundation::users/' . $user->id), '#' . $user->id . ' ' . $user->fullname);
            });
        }

        return $builder->editColumn('field_1', $this->getFieldOneColumnValue())
                        ->editColumn('field_2', $this->getFieldRow('field_2'))
                        ->addColumn('action', function($row) {
                            return $this->rowActions($row);
                        })->make(true);
    }

    /**
     * Gets field 1 colum value
     * 
     * @return Closure
     */
    protected function getFieldOneColumnValue()
    {
        return function($row) {
            $value = is_null($row->value) ? null : array_get($row->value, 'field_1');
            if (is_null($value)) {
                return '---';
            }
            return array_get(ModuleProcessor::getOptions(), $value, '---');
        };
    }

    /**
     * Gets field row decorator
     * 
     * @param String $label
     * @return Closure
     */
    protected function getFieldRow($label)
    {
        return function($row) use($label) {
            if (is_null($row->value)) {
                return '---';
            }
            $value = array_get($row->value, $label);
            $class = ($value) ? 'success' : 'danger';
            $label = ($value) ? 'yes' : 'no';
            return '<span class = "label-basic label-basic--' . $class . '">' . trans('antares/foundation::messages.' . $label) . '</span >';
        };
    }

    /**
     * Definiowanie akcji dostępnych na wierszach tabeli
     * 
     * @param \Illuminate\Database\Eloquent\Model $row
     * @return String
     */
    protected function rowActions($row)
    {

        $btns    = [];
        $html    = app('html');
        $btns[]  = $html->create('li', $html->link(handles("antares::sample_module/index/{$row->id}/edit"), trans('antares/sample_module::messages.edit'), ['data-icon' => 'edit']));
        $btns[]  = $html->create('li', $html->link(handles("antares::sample_module/index/{$row->id}/delete", ['csrf' => true]), trans('antares/sample_module::messages.delete'), [
                    'class'            => "triggerable confirm",
                    'data-icon'        => 'delete',
                    'data-title'       => trans("antares/sample_module::messages.are_you_sure"),
                    'data-description' => trans('antares/sample_module::messages.deleting_row', ['name' => $row->name])]));
        $section = $html->create('div', $html->create('section', $html->create('ul', $html->raw(implode('', $btns)))), ['class' => 'mass-actions-menu'])->get();
        return '<i class="zmdi zmdi-more"></i>' . app('html')->raw($section)->get();
    }

    /**
     * Określenie instancji, ustawienie kolumn na podstawie których zostanie wygenerowany prototyp tabeli
     * 
     * @return \Antares\Datatables\Html\Builder
     */
    public function html($url = null)
    {

        $html    = app('html');
        $builder = $this->setName('Module List')
                ->addColumn(['data' => 'id', 'name' => 'id', 'title' => trans('antares/sample_module::datagrid.header.id')])
                ->addColumn(['data' => 'name', 'name' => 'name', 'title' => trans('antares/sample_module::datagrid.header.name'), 'className' => 'bolded']);
        if (!auth()->user()->hasRoles('member')) {
            $builder->addColumn(['data' => 'user_id', 'name' => 'user_id', 'title' => trans('antares/sample_module::datagrid.header.user')]);
        }


        return $builder->addColumn(['data' => 'field_1', 'name' => 'field_1', 'title' => trans('antares/sample_module::datagrid.header.field_1')])
                        ->addColumn(['data' => 'field_2', 'name' => 'field_2', 'title' => trans('antares/sample_module::datagrid.header.field_2')])
                        ->addAction(['name' => 'edit', 'title' => '', 'class' => 'mass-actions dt-actions'])
                        ->ajax(is_null($url) ? handles('antares::sample_module/index') : $url)
                        ->addGroupSelect($this->users(), 2, 1)
                        ->setDeferedData();
    }

    /**
     * Creates select for statuses
     *
     * @return String
     */
    protected function users()
    {
        $rows   = \Antares\SampleModule\Model\ModuleRow::query()->groupBy('user_id')->with('user')->get();
        $return = ['' => trans('antares/users::messages.statuses.all')];
        foreach ($rows as $row) {
            $return[$row->user_id] = $row->user->fullname;
        }
        return $return;
    }

    /**
     * Gets patterned url for search engines
     * 
     * @return String
     */
    public static function getPatternUrl()
    {
        return handles('antares::sample_module/index/{id}/edit');
    }

}
