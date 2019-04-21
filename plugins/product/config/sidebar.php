<?php

return [
    [
        'id'          => 'menu-product-administrator',
        'priority'    => 1,
        'parent_id'   => null,
        'name'        => 'plugins-product::sidebar.administrator',
        'icon'        => 'fas fa-users-cog',
        'url'         => null,
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-product-product',
        'priority'    => 1,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.product',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.list',
        'permissions' => ['product.list']
    ],
    [
        'id'          => 'menu-product-categories',
        'priority'    => 2,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.category',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.category.list',
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-product-manufacturers',
        'priority'    => 3,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.manufacturer',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.manufacturer.list',
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-product-colors',
        'priority'    => 4,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.color',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.color.list',
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-product-business-types',
        'priority'    => 5,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.business-type',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.business-type.list',
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-product-collections',
        'priority'    => 6,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.collection',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.collection.list',
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-product-materials',
        'priority'    => 7,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.material',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.material.list',
        'permissions' => ['product.index']
    ],
    [
        'id'          => 'menu-look-books',
        'priority'    => 8,
        'parent_id'   => 'menu-product-administrator',
        'name'        => 'plugins-product::sidebar.look_book',
        'icon'        => 'fas fa-users-cog',
        'url'         => 'admin.product.look_book.list',
        'permissions' => ['product.index']
    ],
];