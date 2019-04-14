<?php

return [
    'pattern'   => '--slug--',
    'supported' => [
        'page',
        'blog-tag',
        'blog-category'
    ],
    'prefixes'  => [
    	'blog-tag' => '/blog/tag/',
    	'blog-category' => '/blog/category/'
    ],
];
