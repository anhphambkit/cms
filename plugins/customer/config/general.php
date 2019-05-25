<?php

return [
    'verify_email' => env('CMS_CUSTOMER_VERIFY_EMAIL', true),
    'avatar' => [
        'folder' => [
            'upload'        => public_path('uploads'),
            'container_dir' => 'members/avatars',
        ],
    ],
];