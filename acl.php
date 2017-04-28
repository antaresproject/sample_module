<?php

use Antares\Acl\RoleActionList;
use Antares\Model\Role;
use Antares\Acl\Action;

$actions = [
    new Action('sample_module.index', 'Index Action'),
    new Action('sample_module.add', 'Add Action'),
    new Action('sample_module.update', 'Update Action'),
    new Action('sample_module.destroy', 'Delete Action'),
    new Action('sample_module.client-list', 'Items List'),
    new Action('sample_module.client-add', 'Item Add'),
    new Action('sample_module.client-update', 'Item Update'),
    new Action('sample_module.client-delete', 'Item Delete'),
];

$permissions = new RoleActionList;
$permissions->add(Role::admin()->name, $actions);

return $permissions;
