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

namespace Antares\Modules\SampleModule\Events;

use Antares\Model\User;
use Antares\Modules\SampleModule\Model\ModuleRow;

abstract class AbstractItemEvent {

    /**
     * @var User
     */
    public $user;

    /**
     * @var ModuleRow
     */
    public $moduleRow;

    /**
     * AbstractItemEvent constructor.
     * @param User $user
     * @param ModuleRow $moduleRow
     */
    public function __construct(User $user, ModuleRow $moduleRow) {
        $this->user = $user;
        $this->moduleRow = $moduleRow;
    }

}