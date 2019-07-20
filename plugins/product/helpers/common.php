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

if (!function_exists('get_array_product_wish_list')) {
    /**
     * @param int $customerId
     * @return mixed
     */
    function get_array_product_wish_list(int $customerId)
    {
        return app()->make(\Plugins\Product\Repositories\Interfaces\WishListRepositories::class)->allBy([
            [
                'customer_id', '=', $customerId
            ]
        ], [], ['id'])->pluck('id')->toArray();
    }
}

if (!function_exists('get_info_basic_cart')) {
    /**
     * @param int $customerId
     * @return mixed
     */
    function get_info_basic_cart(int $customerId)
    {
        return app()->make(\Plugins\Cart\Services\CartServices::class)->getBasicInfoCartOfCustomer($customerId);
    }
}

if (!function_exists('get_position_popup')) {
    /**
     * @param float $left
     * @param float $top
     * @return array
     */
    function get_position_popup(float $left, float $top)
    {
        if ($top <= 30 && $left <= 40) {
            return [
                'top' => "48px",
                'left' => "0",
                'class' => 'align-top-left',
                'is_top' => true,
                'is_right' => false,
            ];
        }
        else if ($top >= 30 && $left <= 40) {
            return [
                'bottom' => "48px",
                'left' => "0",
                'class' => 'align-bottom-left',
                'is_top' => false,
                'is_right' => false,
            ];
        }
        else if ($top <= 30 && $left > 40) {
            return [
                'top' => "48px",
                'right' => "0",
                'class' => 'align-top-right',
                'is_top' => true,
                'is_right' => true,
            ];
        }
        else {
            return [
                'bottom' => "48px",
                'right' => "0",
                'class' => 'align-bottom-right',
                'is_top' => false,
                'is_right' => true,
            ];
        }
    }
}