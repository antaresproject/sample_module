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

namespace Antares\Modules\SampleModule\Customfields;

use Illuminate\Database\Eloquent\Model;
use Antares\Customfield\CustomField;
use Antares\Model\UserMeta;

class UrlField extends CustomField
{

    /**
     * Name of customfield
     *
     * @var String 
     */
    protected $name = 'url';

    /**
     * Validation rules
     *
     * @var array 
     */
    protected $rules = [
        'url' => ['required', 'exists_db']
    ];

    /**
     * Field attributes
     *
     * @var array 
     */
    protected $attributes = [
        'id'         => 'url',
        'name'       => 'url',
        'value'      => '',
        'label'      => 'Custom field url',
        'attributes' => [
            'placeholder' => 'your homepage url...',
        ],
        'wrapper'    => [
            'class' => 'w500'
        ],
        'type'       => 'input:text'
    ];

    /**
     * Validates customfield when submitted from form
     * 
     * @return \Illuminate\Validation\Factory
     */
    public function onValidate()
    {
        return $this->validator->extend('exists_db', function ($attribute, $value, $parameters) {
                    return true;
                }, 'Bad url format.');
    }

    /**
     * On save customfield data
     * 
     * @param Model $user
     * @return Model
     */
    public function onSave(Model $user)
    {
        $model        = UserMeta::query()->firstOrNew(['user_id' => $user->id, 'name' => 'url']);
        $model->value = input('url');
        return $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        $model = UserMeta::query()->where(['user_id' => $this->model->id, 'name' => 'url'])->first();
        return !is_null($model) ? $model->value : false;
    }

}
