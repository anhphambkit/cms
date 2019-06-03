<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('get_total_items_in_cart')) {
    /**
     * @return mixed
     */
    function get_total_items_in_cart()
    {
        if (Auth::guard('customer')->check())
            return app()->make(\Plugins\Cart\Services\CartServices::class)->getTotalItemsInCart(Auth::guard('customer')->id());
        return 0;
    }
}
