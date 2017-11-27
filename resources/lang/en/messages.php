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
return
        [
            'configuration'                => [
                'labels'       => [
                    'name'        => 'Name',
                    'url'         => 'Url',
                    'checkbox'    => 'Checkbox',
                    'date_format' => 'Date format',
                    'country'     => 'Country',
                    'description' => 'Description'
                ],
                'placeholders' => [
                    'name' => 'entity name...',
                    'url'  => 'entity url...',
                ]
            ],
            'title'                        => 'Sample module',
            'user_updated'                 => 'User has been updated.',
            'delete'                       => 'Delete',
            'are_you_sure'                 => 'Are you sure?',
            'delete_item'                  => 'Deleteing item :name',
            'delete_mass_action'           => 'Are you sure, to delete selected rows?',
            'edit'                         => 'Edit',
            'save_error'                   => 'Item has not been added. Error appears while saving to database.',
            'save_success'                 => 'Item has been added.',
            'update_error'                 => 'Item has not been updated. Error appears while saving to database.',
            'update_success'               => 'Item has been updated.',
            'deleting_row'                 => 'Deleting item :name...',
            'item_has_not_been_deleted'    => 'Item :name has not been deleted.',
            'item_has_been_deleted'        => 'Item :name has been deleted.',
            'breadcrumb'                   => [
                'item_edit' => 'Edit: #:id, :name',
                'item_add'  => 'Add item'
            ],
            'configuration_has_been_saved' => 'Configuration has been saved.'
];
