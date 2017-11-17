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

namespace Antares\Modules\SampleModule\Notifications;

use Antares\Model\User;
use Antares\Modules\SampleModule\Model\ModuleRow;
use Antares\Notifications\AbstractNotification;
use Antares\Notifications\Contracts\NotificationEditable;
use Antares\Notifications\Model\Template;

abstract class AbstractItemNotification extends AbstractNotification implements NotificationEditable {

    /**
     * User instance.
     *
     * @var User
     */
    protected $user;

    /**
     * Module row instance.
     *
     * @var ModuleRow
     */
    protected $moduleRow;

    /**
     * AbstractItemNotification constructor.
     * @param User $user
     * @param ModuleRow $moduleRow
     */
    public function __construct(User $user, ModuleRow $moduleRow) {
        $this->user = $user;
        $this->moduleRow = $moduleRow;
    }

    /**
     * Returns template for notification.
     *
     * @return Template
     */
    abstract protected static function mailMessage();

}