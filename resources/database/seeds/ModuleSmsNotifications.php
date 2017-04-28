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

class ModuleSmsNotifications extends NotificationSeeder
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
                'event'    => 'sms.module_sms_notification',
                'contents' => [
                    'en' => [
                        'title'   => 'Sms notification send test',
                        'content' => 'Sms notification send test.'
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
                    'sms.module_sms_notification',
        ]);
    }

}
