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
 * @package    Notifications
 * @version    0.9.0
 * @author     Antares Team
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, Antares Project
 * @link       http://antaresproject.io
 */
use Antares\Notifier\Seeder\NotificationSeeder;
use Illuminate\Support\Facades\DB;

class ModuleEmailNotification extends NotificationSeeder
{

    /**
     * Creates module notifications
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        try {
            $this->down();
            $this->addNotification([
                'category' => 'default',
                'severity' => 'high',
                'type'     => 'email',
                'event'    => 'email.sample-module-notification',
                'contents' => [
                    'en' => [
                        'title'   => 'Sample Email Template',
                        'content' => file_get_contents(__DIR__ . '/../../views/notification/module_sample_notification.twig')
                    ],
                ]
            ]);
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }

        DB::commit();
    }

    /**
     * Usuwa dane do tabel
     *
     * @return void
     */
    public function down()
    {
        return $this->deleteNotificationByEventName([
                    'email.sample-module-notification',
        ]);
    }

}
