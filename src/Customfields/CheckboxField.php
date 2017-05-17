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

class CheckboxField extends CustomField
{

    /**
     * Name of customfield
     *
     * @var String 
     */
    protected $name = 'send_notifications';

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
        'id'    => 'send_notifications',
        'name'  => 'send_notifications',
        'value' => '',
        'label' => 'Allow to send notification',
        'type'  => 'input:checkbox',
    ];

    /**
     * On save customfield data
     * 
     * @param Model $user
     * @return Model
     */
    public function onSave(Model $user)
    {
        $model        = $this->getModel($user);
        $model->value = input('send_notifications');
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
