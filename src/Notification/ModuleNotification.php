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

namespace Antares\SampleModule\Notification;

use Antares\View\Notification\Notification;

class ModuleNotification extends Notification
{

    /**
     * type of notification template
     *
     * @var String
     */
    protected $type = 'email';

    /*
     * notification template title
     * 
     * @var String
     */
    protected $title = 'Email notification from module';

    /**
     * container with available languages
     *
     * @var array 
     */
    protected $availableLanguages = [
        'en'
    ];

    /**
     * default template language
     *
     * @var String
     */
    protected $defaultLanguage = 'en';

    /**
     * template paths
     *
     * @var array
     */
    protected $templatePaths = [
        'en' => 'antares/sample_module::notification.module',
    ];

    /**
     * notification events
     *
     * @var array 
     */
    protected $events = [
        'post_item_add'
    ];

    /**
     * notification category
     *
     * @var type 
     */
    protected $category = 'default';

    /**
     * default recipients
     *
     * @var array 
     */
    protected $recipients = [];

}
