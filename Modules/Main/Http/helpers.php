<?php

use Illuminate\Support\Facades\Route;

if (!function_exists('isActive')) {
    function isActive($key, $activeClassName = 'active')
    {
        if (is_array($key)) {
            return in_array(Route::currentRouteName(), $key) ? $activeClassName : "";
        }
        return Route::currentRouteName() === $key ? $activeClassName : "";
    }
}
if (!function_exists('isUrl')) {
    function isUrl($key, $activeClassName = 'active')
    {
        return request()?->fullUrlIs($key) ? $activeClassName : "";
    }
}

if (!function_exists('paymentType')) {

    function paymentType($item = null)
    {
        $array = [
            'nextPay' => 'نکست پی',
            'payPing' => 'پی پینگ',
            'crypto' => 'رمز ارز',
            'paypal' => 'پی پال',
        ];
        if (is_null($item)) return $array;
        return $array[$item];
    }
}

if (!function_exists('orderTypes')) {

    function orderTypes($item = null)
    {
        $array = [
            'unpaid' => 'پرداخت نشده',
            'paid' => 'پرداخت شده',
            'preparation' => 'در حال بررسی',
            'posted' => 'ارسال شده',
            'received' => 'دریافت شده',
            'canceled' => 'لغو شده',
        ];
        if (is_null($item)) return $array;
        return $array[$item];
    }
}
if (!function_exists('orderStatusClass')) {

    function orderStatusClass($item = null)
    {
        $array = [
            'unpaid' => 'warning',
            'paid' => 'info',
            'preparation' => 'primary',
            'posted' => 'light',
            'received' => 'success',
            'canceled' => 'danger',
        ];
        if (is_null($item)) return $array;
        return $array[$item];
    }
}
