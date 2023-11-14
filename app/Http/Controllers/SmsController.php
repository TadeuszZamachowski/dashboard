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

    // public function sendSMS(Request $request)
    public function sendSMS()
    {
        // $this->validate($request, [
        //     'phone' => 'required',
        //     'message' => 'required',
        // ]);
        $response = $this->twilioService->sendSMS('+610493754103', 'Filip mi płaci mało pieniędzy');
        if ($response->sid) {
            return redirect('/')->with('success','Sms sent!');
        } else {
 
            return redirect('/')->with('error','Sms notsent!');
        }
    }

}
