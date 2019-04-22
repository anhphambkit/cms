<?php
return [
    [
        'name' => 'Payment',
        'flag' => 'payment.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'payment.create',
        'parent_flag' => 'payment.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'payment.edit',
        'parent_flag' => 'payment.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'payment.delete',
        'parent_flag' => 'payment.list',
    ]
];