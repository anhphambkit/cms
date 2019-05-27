<?php

return [
	[
        'id'          => 'menu-custom-attribute',
        'priority'    => 11,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-custom-attributes::sidebar.custom_attributes',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.custom-attributes.list',
        'permissions' => ['custom-attributes.list']
    ],
];