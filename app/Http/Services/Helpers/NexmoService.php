<?php

namespace App\Services\Helpers;

use Nexmo\Client\Credentials\Basic;
use Nexmo\Client;
use Nexmo\Client\Exception\Request as NexmoExceptionRequest;
use Log;

class NexmoService
{
    public static function send($phoneNumber, $content)
    {
        $basic = new Basic(env('NEXMO_API_KEY'), env('NEXMO_API_SECRET'));
        $client = new Client($basic);

        try {
            $codeError = $client->message()->send([
                'to' => $phoneNumber,
                'from' => env('NEXMO_FROM_SEND'),
                'text' => $content,
            ]);

            return true;
        } catch (NexmoExceptionRequest $e) {
            Log::error($e); //Nexmo error
        }
        throw new \Exception('Nexmo send sms code error', 200);
    }

    public static function generateRandomString($length = 6)
    {
        return substr(sha1(rand()), 0, $length);
    }
}