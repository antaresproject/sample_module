<?php

use Antares\Acl\RoleActionList;
use Antares\Model\Role;
use Antares\Acl\Action;

$actions       = [
    /** pierwszy argument oznacza nazwę routingu, drugi to umowna nazwa akcji * */
    new Action('admin.sample_module.index', 'Index Action'),
    new Action('admin.sample_module.add', 'Add Action'),
    new Action('admin.sample_module.update', 'Update Action'),
    new Action('admin.sample_module.destroy', 'Delete Action'),
    new Action('admin.sample_module.client-list', 'Items List'),
    new Action('admin.sample_module.client-add', 'Item Add'),
    new Action('admin.sample_module.client-update', 'Item Update'),
    new Action('admin.sample_module.client-delete', 'Item Delete'),
];
/** member actions * */
$memberActions = [
    new Action('admin.sample_module.client-list', 'Items List'),
    new Action('admin.sample_module.client-add', 'Item Add'),
    new Action('admin.sample_module.client-update', 'Item Update'),
    new Action('admin.sample_module.client-delete', 'Item Delete'),
];

$permissions = new RoleActionList;
$permissions->add(Role::admin()->name, $actions);

return $permissions;
