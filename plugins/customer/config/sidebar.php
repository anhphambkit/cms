<?php

return [
	[
		'id'          => 'menu-customer-administrator',
		'priority'    => 1,
		'parent_id'   => null,
		'name'        => 'plugins-customer::sidebar.administrator',
		'icon'        => 'fas fa-users-cog',
		'url'         => null,
		'permissions' => ['customer.index']
    ],
    [
		'id'          => 'menu-customer-customer',
		'priority'    => 1,
		'parent_id'   => 'menu-customer-administrator',
		'name'        => 'plugins-customer::sidebar.customer',
		'icon'        => 'fas fa-users-cog',
		'url'         => 'admin.customer.list',
		'permissions' => ['customer.list']
    ],
];