<?php

use Antares\Acl\RoleActionList;
use Antares\Model\Role;
use Antares\Acl\Action;

$actions     = [
    new Action('', 'Index Action'),
    new Action('', 'Add Action'),
    new Action('', 'Update Action'),
    new Action('', 'Delete Action'),
    new Action('', 'Items List'),
    new Action('', 'Item Add'),
    new Action('', 'Item Update'),
    new Action('', 'Item Delete'),
];
$permissions = new RoleActionList;
$permissions->add(Role::admin()->name, $actions);

return $permissions;
