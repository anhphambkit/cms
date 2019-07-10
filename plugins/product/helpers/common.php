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
        if ($top <= 50) {
            return [
                'top' => "calc({$top}% + 50px)",
                'left' => "calc({$left}% - 110px)",
                'class' => 'align-top',
                'is_top' => true,
            ];
        }
        else {
            return [
                'bottom' => "calc(100% - {$top}% + 15px)",
                'left' => "calc({$left}% - 110px)",
                'class' => 'align-bottom',
                'is_top' => false,
            ];
        }
    }
}