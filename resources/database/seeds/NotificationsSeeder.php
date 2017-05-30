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
use Antares\Notifier\Seeder\NotificationSeeder;
use Illuminate\Support\Facades\DB;

class NotificationsSeeder extends NotificationSeeder
{

    /**
     * Dodaje dane do tabel
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
                'severity' => 'medium',
                'event'    => 'notifications.item_has_been_created',
                'contents' => [
                    'en' => [
                        'title'   => 'Item has been created',
                        'content' => 'Item with name <strong>[[ item.name ]]</strong> has been created by [[ user.firstname ]] [[ user.lastname ]] in application [[ foundation::site.name ]]'
                    ],
                ]
            ]);

            $this->addNotification([
                'category' => 'default',
                'severity' => 'high',
                'event'    => 'notifications.item_has_not_been_created',
                'contents' => [
                    'en' => [
                        'title'   => 'Item has not been created',
                        'content' => 'Error appears while adding item with name <strong>[[ item.name ]]</strong> by [[ user.firstname ]] [[ user.lastname ]] in application [[ foundation::site.name ]]'
                    ],
                ]
            ]);

            $this->addNotification([
                'category' => 'default',
                'severity' => 'medium',
                'event'    => 'notifications.item_has_been_updated',
                'contents' => [
                    'en' => [
                        'title'   => 'Item has been updated',
                        'content' => 'Item with name <strong>[[ item.name ]]</strong> has been updated by [[ user.firstname ]] [[ user.lastname ]] in application [[ foundation::site.name ]]'
                    ],
                ]
            ]);

            $this->addNotification([
                'category' => 'default',
                'severity' => 'high',
                'event'    => 'notifications.item_has_not_been_updated',
                'contents' => [
                    'en' => [
                        'title'   => 'Item has not been updated',
                        'content' => 'Error appears while updating item <strong>[[ item.name ]]</strong> by [[ user.firstname ]] [[ user.lastname ]] in application [[ foundation::site.name ]]'
                    ],
                ]
            ]);
            $this->addNotification([
                'category' => 'default',
                'severity' => 'medium',
                'event'    => 'notifications.item_has_been_deleted',
                'contents' => [
                    'en' => [
                        'title'   => 'Item has been deleted',
                        'content' => 'Item with name <strong>[[ item.name ]]</strong> has been deleted by [[ user.firstname ]] [[ user.lastname ]] in application [[ foundation::site.name ]]'
                    ],
                ]
            ]);
            $this->addNotification([
                'category' => 'default',
                'severity' => 'high',
                'event'    => 'notifications.item_has_not_been_deleted',
                'contents' => [
                    'en' => [
                        'title'   => 'Item has not been deleted',
                        'content' => 'Error appears while deleting item <strong>[[ item.name ]]</strong> by [[ user.firstname ]] [[ user.lastname ]] in application [[ foundation::site.name ]]'
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
                    'notifications.item_has_been_created',
                    'notifications.item_has_not_been_created',
                    'notifications.item_has_been_updated',
                    'notifications.item_has_not_been_updated',
                    'notifications.item_has_been_deleted',
                    'notifications.item_has_not_been_deleted',
        ]);
    }

}
