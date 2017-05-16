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

namespace Antares\Modules\SampleModule\Customfields;

use Illuminate\Database\Eloquent\Model;
use Antares\Customfield\CustomField;
use Antares\Model\UserMeta;

class RadiosField extends CustomField
{

    /**
     * Name of customfield
     *
     * @var String 
     */
    protected $name = 'log_activity';

    /**
     * Validation rules
     *
     * @var array 
     */
    protected $rules = [];

    /**
     * Field attributes
     *
     * @var array 
     */
    protected $attributes = [
        'id'    => 'disable_log_activity',
        'name'  => 'disable_log_activity',
        'value' => '',
        'label' => 'Disable log acitivity',
        'type'  => 'input:radio',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->attributes['options'] = function() {
            return collect([
                '0' => 'No',
                '1' => 'Yes'
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
        $model        = $this->getModel($user);
        $model->value = input('disable_log_activity');
        return $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function getValue()
    {
        $model = $this->getModel($this->model);
        return !is_null($model) ? $model->value : false;
    }

    protected function getModel($model)
    {
        return UserMeta::query()->where(['user_id' => $model->id, 'name' => 'send_notifications'])->first();
    }

}
