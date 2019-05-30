<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


if (!function_exists('get_current_customer')) {
    /**
     * @author TrinhLe
     * Get curent customer
    */
    function get_current_customer()
    {
        return Auth::guard('customer')->user();
    }
}

if (!function_exists('get_customer_address_default')) {
    /**
     * @author TrinhLe
     * Get default address customer
    */
    function get_customer_address_default(bool $isShipping = true)
    {
    	$customer = get_current_customer();
        $address = json_decode($customer->address);
        if($address){
        	foreach ($address as $_address) 
        	{
        		if(!$isShipping && $_address->is_default_billing)
        			return $_address;
        		if($isShipping && $_address->is_default_shipping)
        			return $_address;
        	}
        }
    }
}
