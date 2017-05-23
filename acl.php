<?php

use Antares\Acl\RoleActionList;
use Antares\Model\Role;
use Antares\Acl\Action;

$actions = [
    'Index Action' => 'Default index preview action. Very first page from main menu.',
    'Sample crud'  => [
        'Add Action'    => 'Allows user to add action.',
        'Update Action' => 'Allows user to update action.',
        'Delete Action' => 'Allows user to delete action.'
    ],
    'Items'        => [
        'Items List'  => 'Allows user to preview items list.',
        'Item Add'    => 'Allows user to add item.',
        'Item Update' => 'Allows user to update item.',
        'Item Delete' => 'Allows user to delete item.',
    ]
];

$imports      = [];
$descriptions = [];
$categories   = [];

foreach ($actions as $index => $action) {
    $import = null;
    if (is_numeric($index)) {
        $imports[] = new Action('', $action);
    } elseif (is_string($index) && is_array($action)) {
        foreach ($action as $name => $description) {
            $imports[]                     = new Action('', $name);
            $descriptions[str_slug($name)] = $description;
            $categories[str_slug($name)]   = $index;
        }
    } else {
        $imports[]                      = new Action('', $index);
        $descriptions[str_slug($index)] = $action;
    }
}
$permissions = new RoleActionList;
$permissions->add(Role::admin()->name, $imports);

$permissions->addDescriptions($descriptions);
$permissions->addCategories($categories);

return $permissions;
