<?php
return [
	[
        'name' => 'Dashboard',
        'flag' => 'dasboard.list',
        'is_feature' => true,
    ],
    [
    	'name' => 'User',
        'flag' => 'user.index',
        'is_feature' => true,
    ],
    [
    	'name' => 'Role',
        'flag' => 'role.index',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'user.create',
        'parent_flag' => 'user.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'user.edit',
        'parent_flag' => 'user.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'user.delete',
        'parent_flag' => 'role.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'role.create',
        'parent_flag' => 'user.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'role.edit',
        'parent_flag' => 'role.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'role.delete',
        'parent_flag' => 'role.index',
    ]
];