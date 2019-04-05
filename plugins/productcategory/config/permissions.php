<?php
return [
    [
        'name' => 'Productcategory',
        'flag' => 'productcategory.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'productcategory.create',
        'parent_flag' => 'productcategory.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'productcategory.edit',
        'parent_flag' => 'productcategory.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'productcategory.delete',
        'parent_flag' => 'productcategory.list',
    ]
];