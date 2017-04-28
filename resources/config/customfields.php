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
return [
    /**
     * model to field map
     */
    Antares\Model\User::class => [
        \Antares\Module\Customfields\UrlField::class,
        \Antares\Module\Customfields\GenderField::class,
        //\Antares\Module\Customfields\CheckboxField::class,
        //\Antares\Module\Customfields\RadiosField::class,
        Antares\Module\Customfields\TextareaField::class
    ],
    App\User::class           => [
    //Antares\Module\Customfields\UrlField::class
    ]
];

