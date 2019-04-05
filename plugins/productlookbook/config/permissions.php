<?php
return [
    [
        'name' => 'Productlookbook',
        'flag' => 'productlookbook.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'productlookbook.create',
        'parent_flag' => 'productlookbook.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'productlookbook.edit',
        'parent_flag' => 'productlookbook.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'productlookbook.delete',
        'parent_flag' => 'productlookbook.list',
    ]
];