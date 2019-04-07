<?php
return [
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
    ]
];