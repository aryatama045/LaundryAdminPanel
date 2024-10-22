<?php

namespace App\Http\Controllers\API\Master;

use App\Http\Controllers\Controller;
use App\Models\DeliveryCost;
use App\Models\MobileAppUrl;
use App\Models\WebSetting;

class masterController extends Controller
{
    public function index()
    {

        $websetting = WebSetting::first();
        $currency = $websetting?->currency ?? config('enums.currency');

        $cost = DeliveryCost::first();
        $costFee = $cost ? $cost->cost : 00.0;
        $fee_cost = $cost ? $cost->fee_cost : 100;
        $mini_cost = $cost ? $cost->minimum_cost : 00;

        $mobileAppLink = MobileAppUrl::first();

        return $this->json('',[
            'currency' => $currency,
            'currency_position' => config('app.currency_position'),
            'delivery_cost' => $costFee,
            'fee_cost' => $fee_cost,
            'minimum_cost' => $mini_cost,
            'post_code' => config('enums.post_code'),
            'android_url' => $mobileAppLink ? $mobileAppLink->android_url : '',
            'ios_url' => $mobileAppLink ? $mobileAppLink->ios_url : ''
        ]);

    }
}
