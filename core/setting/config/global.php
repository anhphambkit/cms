<?php
return [
    'general' => [
        'name' => trans('settings::setting.general.general_block'),
        'settings' => [
            [
                'label' => trans('settings::setting.general.rich_editor'),
                'type' => 'select',
                'attributes' => [
                    'name' => 'rich_editor',
                    'list' => [
                        'ckeditor' => 'Ckeditor',
                        'tinymce' => 'Tinymce',
                    ],
                    'value' => 'ckeditor',
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.site_title'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'site_title',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.site_title'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.banner_homepage_content'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'banner_homepage_content',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.banner_homepage_content'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.show_admin_bar'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'show_admin_bar',
                    'value' => 1,
                ],
            ],
            [
                'label' => trans('settings::setting.general.enable_change_admin_theme'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'enable_change_admin_theme',
                    'value' => 1,
                ],
            ],
            [
                'label' => trans('settings::setting.general.enable_multi_language_in_admin'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'enable_multi_language_in_admin',
                    'value' => 1,
                ],
            ],
        ]
    ],
    'seo' => [
        'name' => trans('settings::setting.general.seo_block'),
        'settings' => [
            [
                'label' => trans('settings::setting.general.seo_title'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'seo_title',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.seo_title'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.seo_description'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'seo_description',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.seo_description'),
                        'data-counter' => 120,
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.seo_keywords'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'seo_keywords',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.seo_keywords'),
                        'data-counter' => 60,
                    ],
                ],
            ],
        ]
    ],
    'webmaster_tools' => [
        'name' => trans('settings::setting.general.webmaster_tools_block'),
        'settings' => [
            [
                'label' => trans('settings::setting.general.google_analytics'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'google_analytics',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.google_analytics'),
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.google_site_verification'),
                'type' => 'text',
                'attributes' => [
                    'name' => 'google_site_verification',
                    'value' => null,
                    'options' => [
                        'class' => 'form-control',
                        'placeholder' => trans('settings::setting.general.placeholder.google_site_verification'),
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.enable_captcha'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'enable_captcha',
                    'value' => 1,
                ],
            ],
        ]
    ],
    'cache' => [
        'name' => 'Cache',
        'settings' => [
            [
                'label' => trans('settings::setting.general.cache_time'),
                'type' => 'number',
                'attributes' => [
                    'name' => 'cache_time',
                    'value' => 10,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.cache_time_site_map'),
                'type' => 'number',
                'attributes' => [
                    'name' => 'cache_time_site_map',
                    'value' => 3600,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ],
            [
                'label' => trans('settings::setting.general.enable_cache'),
                'type' => 'onOff',
                'attributes' => [
                    'name' => 'enable_cache',
                    'value' => 1,
                ],
            ],
        ]
    ]
];