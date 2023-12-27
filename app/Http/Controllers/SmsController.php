<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Services\TwilioService;
use Twilio\Exceptions\RestException;
use Google\Service\BackupforGKE\Restore;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    protected $twilioService;
    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    public function index() {
        return view('messages.index');
    }

    public function send(Request $request) {
        $orders = DashboardOrder::distinct('mobile')->get();
        
        $response = "";
        foreach($orders as $order) {
            $attempt = $this->sendSMS($order->mobile, $request->sms_input);
            if($attempt == 1) {
                $response .= $order->dashboard_order_id. " ". $order->first_name. " Sms sent!". "\r\n";
            } else {
                $response .= $order->dashboard_order_id. " ". $order->first_name. " Error sending sms, mobile number - ". $order->mobile. "\r\n";
            }
        }
        return redirect('/messages')->with('success',$response);
    }

    //Used in DashboardOrderController and BikesDashboardOrderController
    public function sendSMS($to, $message)
    {
        try {
            $response = $this->twilioService->sendSMS($to, $message);
            if ($response->sid) {
                return 1;
            }
        } catch(RestException $e) {
            return -1;
        }
        
    }

    public static function checkOneHourBeforeStartDate() {
        
        $orders = DashboardOrder::where("order_status", "LIKE", "Processing")->get();
        $today = date('Y-m-d H:i');
        $smsSent = "";
        foreach($orders as $order) {
            if($order->start_date_sms != 1) { //SMS hasn't been sent previously
                $date = date('Y-m-d H:i',strtotime($order->start_date));
                $hourDiff = UtilController::getHours($today, $date); 

                if($hourDiff <= 1) { //rent date one hour from now
                    $sms = new SmsController(new TwilioService());
                    $response = $sms->sendSMS($order->mobile, self::getMessageStartDate());
    
                    if($response == 1) { //sms succesfully sent
                        $order->start_date_sms = 1;
                        $order->save();
                        $smsSent .= "Pre rental Sms sent to ".$order->first_name." | ";
                    }
                }
            }
        }
        if($smsSent=="") {
            $smsSent = "No pre rental sms sent";
        }
        return $smsSent;
    }

    //assigned
    public static function checkOneHourBeforeEndDate() {
        $orders = DashboardOrder::where("order_status", "LIKE", "Assigned")->get();
        $today = date('Y-m-d H:i');
        $smsSent = "";
        foreach($orders as $order) {
            if($order->end_date_sms != 1) {
                $date = date('Y-m-d H:i',strtotime($order->end_date));
                $hourDiff = UtilController::getHours($today, $date); 

                if($hourDiff <= 1) {
                    $sms = new SmsController(new TwilioService());
                    $response = $sms->sendSMS($order->mobile, self::getMessageEndDate());
    
                    if($response == 1) {
                        $order->end_date_sms = 1;
                        $order->save();
                        $smsSent .= "Reminder Sms sent to ".$order->first_name." | ";
                    }
                }
            }
        }
        if($smsSent=="") {
            $smsSent = "No reminder sms sent";
        }
        return $smsSent;
    }

    public static function getReturnMessage() {
        return "Greetings! Appreciate the return of the bikes. Feel free to share images from your journey; we'd love to showcase them in our weekly social media post. Also, kindly leave a review here: https://g.page/r/CbxYagpHSIZxEAI/review 😉🙏";
    }
    public static function getMessageStartDate() {
        return "Greetings! Thank you for your order. If you haven't submitted the rental agreement yet, please do by clicking on this link https://form.jotform.com/233026632488862. Visit the Woolworth Underground Carpark, specifically the Bicycle Storage room next to the Public Toilets, and text us the rack numbers of the chosen bikes. We'll promptly provide you with the unlock codes. Ensure that your bike selection includes any accessories as per your order. Feel free to call us if you require assistance with picking up the bikes +61 418 883 631";
    }

    public static function getMessageEndDate() {
        return "Hello! I trust you had a fantastic bike riding experience! Just a friendly reminder: your bikes are scheduled to be returned in 1 hour. Feel free to share photos of your adventure with us! :)";
    }

    public static function getMessageWithBikes($assignedBikes) {
        $message = 'Here are your rack numbers and codes: '. "\r\n";
        foreach($assignedBikes as $bike) {
            $message .= '=> Rack: '. $bike->rack .' | Code: '.$bike->code . "\r\n";
        }
        $message .= 'Please take a photo of the bike when picking it up and send it to +61 418 883 631. Upon return, hang the bike on the same bike rack. Attach the bike with the same lock code and send us a photo again.';
        return $message;   
    }

    public function schedule() {
        return view('smsScheduled');
    }

}
