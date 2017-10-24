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
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares
 * @link       http://antaresproject.io
 */

namespace Antares\Modules\SampleModule\Customfields;

use Illuminate\Database\Eloquent\Model;
use Antares\Customfield\CustomField;
use Antares\Model\UserMeta;

class GenderField extends CustomField
{

    /**
     * Name of customfield
     *
     * @var String 
     */
    protected $name = 'gender';

    /**
     * Validation rules
     *
     * @var array 
     */
    protected $rules = [
        'gender' => ['required']
    ];

    /**
     * Whether field should be automatically displayed in form
     *
     * @var type 
     */
    protected $formAutoDisplay = true;

    /**
     * Field attributes
     *
     * @var array 
     */
    protected $attributes = [
        'id'         => 'gender',
        'name'       => 'gender',
        'value'      => '',
        'label'      => 'Custom field gender select',
        'attributes' => [
            'placeholder'   => 'select gender...',
            'data-selectar' => true
        ],
        'type'       => 'select',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->attributes['options'] = function() {
            return collect([
                'm' => 'M',
                'f' => 'F'
            ]);
        };
    }

    /**
     * On save customfield data
     * 
     * @param Model $user
     * @return Model
     */
    public function onSave(Model $user)
    {
//        $model        = $this->getModel($user);
//        $model->value = input('gender');
//        return $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        if (is_null($this->model->id)) {
            return false;
        }
        $model = $this->getModel($this->model);
        return !is_null($model) ? $model->value : false;
    }

    protected function getModel($model)
    {
        return UserMeta::query()->firstOrCreate(['user_id' => $model->id, 'name' => 'gender']);
    }

}
