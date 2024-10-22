<?php
namespace App\Services;

class NotificationServices
{
    public string $message;
    public array $tokens;
    public $title, $body;
    public function __construct(string $message, array $tokens, $title = null, $body = null)
    {
        $this->message = $message;
        $this->tokens = $tokens;
        $this->title = $title ?? 'Laundry';
        $this->body = $body;

        return $this->sendNotification();
    }

    public function sendNotification()
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $data = [
            "registration_ids" => $this->tokens,
            "notification" => [
                "title" => $this->title,
                "body" => $this->message,
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . config('app.fcm_server_key'),
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        // Close connection
        curl_close($ch);
        // FCM response
        return $result;
    }
}
