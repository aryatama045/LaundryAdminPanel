<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class SMS
{
   /**
     * @inheritDoc
     */


    // public function sendSms($mobile, $otp, $isDummy)
    public function sendSms($mobile, $message)
    {
        $code = substr($mobile, 0, 2);
        $mobile = $code == 44 ? $mobile : 44 . $mobile;

        Http::get(config('app.sms_base_url'), [
            'USER_NAME' => config('app.sms_user_name'),
            'PASSWORD' => config('app.sms_password'),
            'ORIGINATOR' => config('app.sms_originator'),
            'RECIPIENT' => $mobile,
            'ROUTE' => config('app.sms_route'),
            'MESSAGE_TEXT' => $message
        ]);

        return true;

    }

    private function callApi($params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, env('SMS_URL'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);

        curl_close($ch);

        return $response;
    }
}
