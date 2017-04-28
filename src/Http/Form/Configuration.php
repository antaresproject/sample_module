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
 * @package    Antares Core
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares Project
 * @link       http://antaresproject.io
 */

namespace Antares\SampleModule\Http\Form;

use Illuminate\Contracts\Container\Container;
use Antares\Contracts\Html\Form\Presenter;
use Antares\Contracts\Html\Form\Fieldset;
use Antares\Html\Form\Grid as HtmlGrid;
use Illuminate\Database\Eloquent\Model;
use Antares\Brands\Model\DateFormat;
use Antares\Html\Form\ClientScript;
use Antares\Html\Form\FormBuilder;
use Antares\Brands\Model\Country;

class Configuration extends FormBuilder implements Presenter
{

    /**
     * Construct
     * 
     * @param Model $model
     */
    public function __construct($model)
    {
        parent::__construct(app(HtmlGrid::class), app(ClientScript::class), app(Container::class));
        $this->grid->name('Sample module configuration');
        $this->grid->setup($this, handles('antares::sample_module/configuration'), $model);
        $this->controlsFieldset();
        $this->grid->rules([
            'name' => ['required'],
            'url'  => ['required', 'ip']
        ]);
    }

    /**
     * creates main controls fieldset
     * 
     * @return \Antares\Html\Form\Fieldset
     */
    protected function controlsFieldset()
    {
        return $this->grid->fieldset(function (Fieldset $fieldset) {
                    $fieldset->legend('Sample Module Configuration');

                    $fieldset->control('input:text', 'name')
                            ->label(trans('antares/sample_module::messages.configuration.labels.name'))
                            ->attributes(['placeholder' => trans('antares/sample_module::messages.configuration.placeholders.name')]);

                    $fieldset->control('input:text', 'url')
                            ->label(trans('antares/sample_module::messages.configuration.labels.url'))
                            ->attributes(['placeholder' => trans('antares/sample_module::messages.configuration.placeholders.url')])
                            ->fieldClass('input-field--group input-field--pre')
                            ->before('<div class="input-field__pre"><span>' . (request()->secure() ? 'https://' : 'http://') . '</span></div>');

                    $fieldset->control('select', 'date_format')
                            ->wrapper(['class' => 'w220'])
                            ->label(trans('antares/sample_module::messages.configuration.labels.date_format'))
                            ->options(function() {
                                return app(DateFormat::class)->query()->get()->pluck('format', 'id');
                            });
                    $options = app(Country::class)->query()->get()->pluck('name', 'code');
                    $fieldset->control('select', 'default_country')
                            ->label(trans('antares/sample_module::messages.configuration.labels.country'))
                            ->attributes(['data-flag-select', 'data-selectAR' => true, 'class' => 'w200'])
                            ->fieldClass('input-field--icon')
                            ->prepend('<span class = "input-field__icon"><span class = "flag-icon"></span></span>')
                            ->optionsData(function() use($options) {
                                $codes  = $options->keys()->toArray();
                                $return = [];
                                foreach ($codes as $code) {
                                    array_set($return, $code, ['country' => $code]);
                                }
                                return $return;
                            })
                            ->options($options);
                    $checkbox = $fieldset->control('input:checkbox', 'checkbox')
                            ->label(trans('antares/sample_module::messages.configuration.labels.checkbox'))
                            ->value(1);
                    if (array_get($this->grid->row, 'checkbox')) {
                        $checkbox->checked();
                    }

                    $fieldset->control('ckeditor', 'content')
                            ->label(trans('antares/sample_module::messages.configuration.labels.description'))
                            ->attributes(['scripts' => true, 'class' => 'richtext'])
                            ->name('content');


                    $fieldset->control('button', 'button')
                            ->attributes(['type' => 'submit', 'value' => trans('Submit'), 'class' => 'btn btn--md btn--primary mdl-button mdl-js-button mdl-js-ripple-effect'])
                            ->value(trans('antares/foundation::label.save_changes'));
                });
    }

    /**
     * {@inheritdoc}
     */
    public function handles($url)
    {
        return handles($url);
    }

}
