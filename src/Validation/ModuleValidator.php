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

namespace Antares\Modules\SampleModule\Validation;

use Illuminate\Support\Facades\Validator as ValidatorFacade;
use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Events\Dispatcher;
use Antares\Support\Validator;

class ModuleValidator extends Validator
{

    /**
     * Konstrukcja obiektu
     * 
     * @param Factory $factory
     * @param Dispatcher $dispatcher
     */
    public function __construct(Factory $factory, Dispatcher $dispatcher)
    {
        parent::__construct($factory, $dispatcher);
        ValidatorFacade::extend('customValidation', '\Antares\Modules\SampleModule\Validation\ModuleValidator@validateCustomValidation');
    }

    /**
     * Reguły walidatora
     *
     * @var type 
     */
    protected $rules = [
        'text'     => ['required', 'custom_validation'],
        'textarea' => ['custom_validation']
    ];

    /**
     * Tłumaczenia błędów walidacji
     *
     * @var array 
     */
    protected $phrases = [
        'required'          => 'The value is required and cannot be empty.',
        'custom_validation' => 'This is custom validation message from foo validator'
    ];

    /**
     * Dedykowana metoda walidacyjna
     * 
     * @param String $field
     * @param mixed $value
     * @param array $parameters
     * @return boolean
     */
    public function validateCustomValidation($field, $value, $parameters)
    {
        return false;
    }

}
