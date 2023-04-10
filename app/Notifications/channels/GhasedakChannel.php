<?php

namespace App\Notifications\channels;

use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Notifications\Notification;

class GhasedakChannel
{

    public function send($notifiable,Notification $notification)
    {
        if(! method_exists($notification , 'toGhasedakSms')){
            throw new \Exception('toGhasedakSms is not found');
        }
        $data = $notification->toGhasedakSms($notifiable);
        $message = $data['text'];
        $receptor = $data['number'];
        $apiKey = config('services.ghasedak.api_key');
        try {
            $lineNumber = '';
            $api = new \Ghasedak\GhasedakApi($apiKey);
            $api->SendSimple($receptor, $message, $lineNumber);
        } catch (ApiException $e) {
            throw $e;
        } catch (HttpException $e) {
            throw $e;
        }

    }
}
