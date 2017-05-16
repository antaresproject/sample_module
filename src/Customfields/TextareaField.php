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

use Antares\Customfield\CustomField;

class TextareaField extends CustomField
{

    /**
     * Name of customfield
     *
     * @var String 
     */
    protected $name = 'notes';

    /**
     * Whether customfield is configurable in web interface
     *
     * @var boolean 
     */
    protected $configurable = false;

    /**
     * Validation rules
     *
     * @var array 
     */
    protected $rules = [
        'notes' => ['required']
    ];

    /**
     * Field attributes
     *
     * @var array 
     */
    protected $attributes = [
        'id'         => 'notes',
        'name'       => 'notes',
        'value'      => '',
        'label'      => 'Notes',
        'attributes' => [],
        'wrapper'    => [
            'class' => 'w500'
        ],
        'type'       => 'textarea'
    ];

}
