<?php

use App\Models\WebSetting;

if (!function_exists('formatMobile')) {
    function formatMobile($mobile)
    {
        return substr(preg_replace('/^\+?1|\|1|\D/', '', $mobile), -11);
    }
}

if (!function_exists('currencyPosition')) {
    function currencyPosition($amount)
    {
        $currency = WebSetting::first()?->currency ?? '$';
        $currencyPosition = config('app.currency_position');
        if ($currencyPosition == 'Suffix') {
            return $amount . $currency;
        }
        return $currency . $amount;
    }
}
