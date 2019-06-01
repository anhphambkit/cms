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
     * stdClass Object
        (
            [address_1] => Address 1
            [address_2] => Address 1
            [city] => HO CHI MINH
            [state] => 4
            [zip] => 700000
            [company_name] => LHT
            [phone_number] => 0345818874
            [is_default_shipping] => on
        )
    */
    function get_customer_address_default(bool $isShipping = true)
    {
    	$customer = get_current_customer();
        $address = json_decode($customer->address);
        if($address){
        	foreach ($address as $_address) 
        	{
        		if(!$isShipping && ($_address->is_default_billing ?? false))
        			return $_address;
        		if($isShipping && ($_address->is_default_shipping ?? false))
        			return $_address;
        	}
        }
    }
}

if (!function_exists('get_address_value_default')) {
    /**
     * @author TrinhLe
     * Get default address value
    */
    function get_address_value_default($address, string $key, $defaultValue = '')
    {
        return $address->{$key} ?? $defaultValue;
    }
}
