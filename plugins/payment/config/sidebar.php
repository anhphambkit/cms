<?php

return [
	[
		'id'          => 'menu-payment-transaction',
		'priority'    => 10,
		'parent_id'   => null,
		'name'        => 'plugins-payment::sidebar.transaction',
		'icon'        => 'fas fa-users-cog',
		'url'         => 'admin.payment.list',
		'permissions' => ['payment.list']
    ],
];