<?php

namespace App\Http\Controllers;

use App\Models\DashboardAutomation;
use App\Models\DashboardMessage;
use App\Models\DashboardOrder;
use App\Services\ClicksendService;
use Twilio\Exceptions\RestException;
use Google\Service\BackupforGKE\Restore;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    //protected $twilioService;
    // public function __construct(TwilioService $twilioService)
    // {
    //     $this->twilioService = $twilioService;
    // }
    protected $clicksendService;

    public function __construct(ClicksendService $clicksendService) {
        $this->clicksendService = $clicksendService;
    }

    public function index() {
        return view('messages.index');
    }

    public function allRecipients() {
        return view('messages.allRecipients');
    }

    public function showMessages() {
        return view('messages.showMessages', [
            'messages' => DashboardMessage::all()
        ]);
    }

    public function edit(DashboardMessage $message) {
        return view('messages.edit', [
            'message' => $message
        ]);
    }

    public function update(Request $request, DashboardMessage $message) {
        $this->validate($request, [
            'value' => 'required',
        ]);

        $data['value'] = $request['value'];
        $message->update($data);
        

        return redirect('/messages/edit')->with('success', 'Message succesfully edited');
    }

    //send one sms to all mobiles in the database
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
        return $this->clicksendService->sendSMS($to, $message); //returns 1 upon success, return -1 if not success
    }

    public static function checkOneHourBeforeStartDate() {

        $setting = DashboardAutomation::where('id', 2)->first();
        if(!$setting->enabled) {
            return "Sms setting disabled";
        }
        
        $orders = DashboardOrder::where("order_status", "LIKE", "Processing")->get();
        $today = date('Y-m-d H:i');
        $smsSent = "";
        foreach($orders as $order) {
            if($order->start_date_sms != 1 && $order->start_date_sms != 2) { //SMS hasn't been sent previously
                $date = date('Y-m-d H:i',strtotime($order->start_date));
                $hourDiff = UtilController::getHours($today, $date); 

                if($hourDiff <= 1) { //rent date one hour from now
                    $message = "";
                    if($order->pickup_location == "Byron Colab 12 Shirley st" || $order->pickup_location == "Glen Villa") {
                        $message = self::getMessageStartDateBus();
                    } else {
                        $message = self::getMessageStartDate();
                    }
                    $response = UtilController::sendMessage($order, $message);
                
                    if(str_contains($response, 'sent!')) { //sms succesfully sent
                            $order->start_date_sms = 1;
                            $order->save();
                            $smsSent .= "Pre rental Sms sent to ".$order->first_name." | ";
                    } else if(str_contains($response, 'email')) {
                        $order->start_date_sms = 2;
                        $order->save();
                        $smsSent .= "Pre rental email sent to ".$order->first_name." | ";
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

        $setting = DashboardAutomation::where('id', 2)->first();
        if(!$setting->enabled) {
            return "Sms setting disabled";
        }

        $orders = DashboardOrder::where("order_status", "LIKE", "Assigned")->get();
        $today = date('Y-m-d H:i');
        $smsSent = "";
        $timeNeededToFire = 0;
        foreach($orders as $order) {
            if($order->end_date_sms != 1 && $order->end_date_sms != 2) {
                $date = date('Y-m-d H:i',strtotime($order->end_date));
                $hourDiff = UtilController::getHours($today, $date); 

                if($order->pickup_location == "Byron Colab 12 Shirley st" || $order->pickup_location == "Glen Villa") {
                    $timeNeededToFire = 0.25;
                } else {
                    $timeNeededToFire = 1;
                }

                if($hourDiff <= $timeNeededToFire) {
                    $message = "";
                    if($order->pickup_location == "Byron Colab 12 Shirley st" || $order->pickup_location == "Glen Villa") {
                        $message = self::getMessageEndDateBus();
                    } else {
                        $message = self::getMessageEndDate();
                    }
                    $response = UtilController::sendMessage($order, $message);

                    if(str_contains($response, 'sent!')) {
                        $order->end_date_sms = 1;
                        $order->save();
                        $smsSent .= "Reminder Sms sent to ".$order->first_name." | ";
                    } else if(str_contains($response, 'email')) {
                        $order->end_date_sms = 2;
                        $order->save();
                        $smsSent .= "Reminder email sent to ".$order->first_name." | ";
                    }
                }
            }
        }
        if($smsSent=="") {
            $smsSent = "No reminder sms sent";
        }
        return $smsSent;
    }

    public static function checkPromo() {

        $setting = DashboardAutomation::where('id', 2)->first();
        if(!$setting->enabled) {
            return "Sms setting disabled";
        }

        $orders = DashboardOrder::where("order_status", "LIKE", "Assigned")->get();
        $today = date('Y-m-d H:i');
        $smsSent = "";
        $timeNeededToFire = 0;
        foreach($orders as $order) {
            if($order->promo_sms != 1 && $order->promo_sms != 2) {
                $date = date('Y-m-d H:i',strtotime($order->end_date));
                $hourDiff = UtilController::getHours($today, $date); 

                if($order->pickup_location == "Byron Colab 12 Shirley st" || $order->pickup_location == "Glen Villa") {
                    $timeNeededToFire = 0.5;
                } else {
                    $timeNeededToFire = 2;
                }

                if($hourDiff <= $timeNeededToFire) {
                    $message = "";
                    if($order->pickup_location == "Byron Colab 12 Shirley st" || $order->pickup_location == "Glen Villa") {
                        $message = self::getPromoMessageBus();
                    } else {
                        $message = self::getPromoMessage();
                    }

                    $response = UtilController::sendMessage($order, $message);

                    if(str_contains($response, 'sent!')) {
                        $order->promo_sms = 1;
                        $order->save();
                        $smsSent .= "Promo Sms sent to ".$order->first_name." | ";
                    } else if(str_contains($response, 'email')) {
                        $order->promo_sms = 2;
                        $order->save();
                        $smsSent .= "Promo email sent to ".$order->first_name." | ";
                    }
                }
            }
        }
        if($smsSent=="") {
            $smsSent = "No promo sms sent";
        }
        return $smsSent;
    }

    public static function getReturnMessage() { //added to database
        $message = DashboardMessage::where('name', 'bike_return')->first();
        return $message->value;
    }

    public static function getReturnMessageBus() { //added to database
        $message = DashboardMessage::where('name', 'bus_bike_return')->first();
        return $message->value;
    }



    public static function getMessageStartDate() { //added to database
        $message = DashboardMessage::where('name', 'new_order')->first();
        return $message->value;
    }

    public static function getMessageStartDateBus() { //added to database
        $message = DashboardMessage::where('name', 'bus_new_order')->first();
        return $message->value;
    }



    public static function getMessageEndDate() { //added to database
        $message = DashboardMessage::where('name', 'reminder')->first();
        return $message->value;
    }

    public static function getMessageEndDateBus() { //added to database
        $message = DashboardMessage::where('name', 'bus_reminder')->first();
        return $message->value;
    }



    public static function getPromoMessage() { //added to database
        $message = DashboardMessage::where('name', 'promo')->first();
        return $message->value;
    }

    public static function getPromoMessageBus() { //added to database
        $message = DashboardMessage::where('name', 'bus_promo')->first();
        return $message->value;
    }

    public function schedule() {
        return view('smsScheduled');
    }

    public static function getMessageWithBikes($assignedBikes) {
        $message = 'Here are your bike numbers and codes: '. "\r\n";
        foreach($assignedBikes as $bike) {
            $message .= '=> Number: '. $bike->id .' | Code: '.$bike->code . "\r\n";
        }
        $dbMessage = DashboardMessage::where('name', 'bike_info')->first();
        $message .= $dbMessage->value;
        return $message;   
    }

    public static function getMessageWithBikesBus($assignedBikes) {
        $message = 'Here are your bike numbers and codes: '. "\r\n";
        foreach($assignedBikes as $bike) {
            $message .= '=> Number: '. $bike->id .' | Code: '.$bike->code . "\r\n";
        }
        $dbMessage = DashboardMessage::where('name', 'bus_bike_info')->first();
        $message .= $dbMessage->value;
        return $message;   
    }

}
