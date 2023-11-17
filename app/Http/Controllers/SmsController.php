<?php

namespace App\Http\Controllers;

use App\Services\TwilioService;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected $twilioService;
    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function sendSMS($to, $message)
    {
        $response = $this->twilioService->sendSMS($to, $message);
        if ($response->sid) {
            return 'Sms sent!';
        } else {
 
            return 'Error sending sms';
        }
    }

}
