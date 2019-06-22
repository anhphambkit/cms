<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Plugins\Customer\Models\Order;

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
        		if(!$isShipping && ($_address->is_default_billing ?? false))
        			return $_address;
        		if($isShipping && ($_address->is_default_shipping ?? false))
        			return $_address;
        	}
        }
    }
}

if (!function_exists('get_order_address_default')) {
    /**
     * @author TrinhLe
     * Get default address order
    */
    function get_order_address_default(Order $order, string $addressKey = '')
    {
        $address = json_decode($order->$addressKey);
        return $address;
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

if (!function_exists('show_fullname_invoce')) {
    /**
     * @author TrinhLe
     * Get default address value
    */
    function show_fullname_invoce($invoice, $defaultValue = 'noreply')
    {
        $address = json_decode($invoice->address_billing);
        return $address->fullname ?? $defaultValue;
    }
}

if (!function_exists('show_address_invoice')) {
    /**
     * @author TrinhLe
     * Get default address value
    */
    function show_address_invoice($invoice, $addressType = 'address_billing')
    {
        $address = json_decode($invoice->$addressType);
        $keys = [
            'address_1',
            'address_2',
            'city',
            'zip',
            'phone_number',
        ];

        foreach ($keys as $value) {
            $results[] = get_address_value_default($address, $value, null);
        }
        return implode(', ', array_filter($results));
    }
}

if (!function_exists('show_email_invoice')) {
    /**
     * @author TrinhLe
     * Get default address value
    */
    function show_email_invoice($invoice,  $defaultValue = 'noreply@gmail.com')
    {
        $address = json_decode($invoice->address_shipping);
        return $address->email ?? $defaultValue;
    }
}