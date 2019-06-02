<?php
return [
    //---------- CUSTOMER ----------//
    [
        'name' => 'Customer',
        'flag' => 'customer.index',
        'is_feature' => true,
    ],
    [
        'name' => 'Customer',
        'flag' => 'customer.list',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Create',
        'flag' => 'customer.create',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Edit',
        'flag' => 'customer.edit',
        'parent_flag' => 'customer.index',
    ],
    [
        'name' => 'Delete',
        'flag' => 'customer.delete',
        'parent_flag' => 'customer.index',
    ],

    //---------- ORDER ----------//
    [
        'name' => 'Order',
        'flag' => 'order.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'order.create',
        'parent_flag' => 'order.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'order.edit',
        'parent_flag' => 'order.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'order.delete',
        'parent_flag' => 'order.list',
    ]
];