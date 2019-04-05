<?php
return [
    [
        'name' => 'Product',
        'flag' => 'product.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'product.create',
        'parent_flag' => 'product.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'product.edit',
        'parent_flag' => 'product.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'product.delete',
        'parent_flag' => 'product.list',
    ]
];