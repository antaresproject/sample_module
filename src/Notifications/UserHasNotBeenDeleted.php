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

namespace Antares\SampleModule\Notifications;

use Antares\Modules\SampleModule\Events\ItemNotDeleted;
use Antares\Notifications\Collections\TemplatesCollection;
use Antares\Notifications\Model\Template;

class UserHasNotBeenDeleted extends AbstractItemNotification {

    /**
     * Returns collection of defined templates.
     *
     * @return TemplatesCollection
     */
    public static function templates() : TemplatesCollection {
        return TemplatesCollection::make('Module Item Not Deleted', ItemNotDeleted::class)
            ->define('mail', static::mailMessage());
    }

    /**
     * Returns template for notification.
     *
     * @return Template
     */
    protected static function mailMessage() {
        $subject    = 'Module item has not been deleted';
        $view       = 'antares/sample_module::notification.module_sample_notification';

        return (new Template(['mail'], $subject, $view))->setSeverity('high')->setRecipients(['admin']);
    }

}
