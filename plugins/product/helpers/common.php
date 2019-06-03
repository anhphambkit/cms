<?php

if (!function_exists('get_menu_product_categories')) {
    /**
     * @return mixed
     */
    function get_menu_product_categories()
    {
        return app()->make(\Plugins\Product\Repositories\Interfaces\ProductCategoryRepositories::class)->allBy([
            [
                'parent_id', '=', 0
            ],
            [
                'status', '=', 1
            ],
            [
                'deleted_at', '=', null
            ]
        ], ['childCategories'], [
            'id', 'name', 'slug', 'image_feature'
        ]);
    }
}
