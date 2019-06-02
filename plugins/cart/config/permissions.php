<?php
return [
    [
        'name' => 'Cart',
        'flag' => 'cart.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'cart.create',
        'parent_flag' => 'cart.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'cart.edit',
        'parent_flag' => 'cart.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'cart.delete',
        'parent_flag' => 'cart.list',
    ]
];