<?php
return [
    [
        'name' => 'Review',
        'flag' => 'review.list',
        'is_feature' => true,
    ],
    [
        'name' => 'Create',
        'flag' => 'review.create',
        'parent_flag' => 'review.list',
    ],
    [
        'name' => 'Edit',
        'flag' => 'review.edit',
        'parent_flag' => 'review.list',
    ],
    [
        'name' => 'Delete',
        'flag' => 'review.delete',
        'parent_flag' => 'review.list',
    ]
];