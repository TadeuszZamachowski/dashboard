<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\DashboardOrderAccessory;
use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\Accessory;
use App\Http\Controllers\SmsController;
use App\Models\DashboardAutomation;
use App\Services\ClicksendService;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public static function assign() { //fires every 2 minutes as a cron job
        $setting = DashboardAutomation::where('id',1)->first();
        if(!$setting->enabled) {
            return view('automationOutput', [
                'output' => 'Automation is disabled'
            ]);
        }

        $orders = DashboardOrder::where('order_status', 'LIKE', 'Processing')->get();
        if($orders->isEmpty()) {
            return view('automationOutput', [
                'output' => 'No processing orders at the moment'
            ]);
        }

        $output = "";
        $today = date('Y-m-d H:i');
        foreach($orders as $order) {
            $date = date('Y-m-d H:i',strtotime($order->start_date));
            $hourDiff = UtilController::getHours($today, $date);
            
            if($hourDiff >= -5 && $hourDiff <= 2) { //start date is half an hour before or 2 hours after

                //if accessory is bike delivery, not assigning and not sending codes
                $accessories = DashboardOrderAccessory::where('order_id', $order->dashboard_order_id)->get();
                if(self::isBikeDelivery($accessories)) {
                    $output = "Bike delivery selected, skipping order ". $order->dashboard_order_id . "\r\n";
                    continue;
                }

                //excluding non physical attachements (like bike delivery etc.)
                $accessories = self::filterAccesssories(DashboardOrderAccessory::where('order_id', $order->dashboard_order_id)->get());
                
                $bikes = array();
                for($i = 0; $i < $order->number_of_bikes; $i++) {
                    $accName = "";//iterating through number of bikes
                    foreach($accessories as $name => &$quantity) {
                        $accName = "";
                        if($quantity >= 1) {
                            $accName = $name;//assigning current accessory name
                            $quantity -= 1;
                            break;//accessory found, breaking from foreach statement
                        }                           
                    }
                    $bike = Bike::where('accessory','LIKE',$accName)//looking for bike with the current accessory name
                                        ->where('status','LIKE','in')
                                        ->where('state', 'NOT LIKE', 'repair')
                                        ->where('location','LIKE', $order->pickup_location)->first();
                    if(!$bike) {
                        $bike = Bike::where('accessory','LIKE','None')//bike with current accessory not found, taking one without an accessory
                                ->where('status','LIKE','in')
                                ->where('state', 'NOT LIKE', 'repair')
                                ->where('type', 'NOT LIKE', 'Kid')//excluding kids bikes
                                ->where('location','LIKE',$order->pickup_location)->first();
                    }
                    //assigning bike to order
                    $bike->update(array(
                        'status' => 'out',
                        'dashboard_order_id' => $order->dashboard_order_id
                    ));
                    $bikes[] = $bike;
                }

                $sms = new SmsController(new ClicksendService());
                $message = "";
                if($order->pickup_location == "Byron Colab 12 Shirley st") {
                    $message = SmsController::getMessageWithBikesBus($bikes);
                } else {
                    $message = SmsController::getMessageWithBikes($bikes);
                }
                $result = $sms->sendSMS($order->mobile, $message);

                if($result == 1) {
                    $output .= "Sent Sms to ". $order->dashboard_order_id. " ". $order->first_name." with bikes ";
                    foreach($bikes as $bike) {
                        //creating history
                        $data['bike_id'] = $bike->id;
                        $data['order_id'] = $order->dashboard_order_id;
                        $data['start_date'] = $order->start_date;
                        $data['end_date'] = $order->end_date;
                        BikesDashboardOrder::create($data);
    
                        //assigning bikes to order
                        $order->update(array(
                            'order_status' => 'Assigned',
                            'bikes_assigned' => 1
                        ));
                        $output .= ' | Number: '. $bike->id .' => Code: '.$bike->code;
                    }
                    $output .= "\r\n";
                } else {
                    //send email;
                    UtilController::sendEmail($order->email, $order->first_name, $message);

                    $output .= "Sent email to ". $order->dashboard_order_id. " ". $order->first_name." with bikes ";
                    foreach($bikes as $bike) {
                        //creating history
                        $data['bike_id'] = $bike->id;
                        $data['order_id'] = $order->dashboard_order_id;
                        $data['start_date'] = $order->start_date;
                        $data['end_date'] = $order->end_date;
                        BikesDashboardOrder::create($data);
    
                        //assigning bikes to order
                        $order->update(array(
                            'order_status' => 'Assigned',
                            'bikes_assigned' => 1
                        ));
                        $output .= ' | Number: '. $bike->id .' => Code: '.$bike->code;
                    }
                    $output .= "\r\n";

                    // foreach($bikes as &$bike) {
                    //     //reverting
                    //     $bike->update(array(
                    //         'status' => 'in',
                    //         'dashboard_order_id' => null
                    //     ));
                    // }
                }
                
            }
        }

        if($output == "") {
            $output = "Nothing sent";
        }
        return view('automationOutput', [
            'output' => $output
        ]);
    }

    public static function filterAccesssories($accessories) {
        $dictionary = Accessory::all();
        $result = array();

        foreach($accessories as $acc) {
            foreach($dictionary as $entry) {
                if ($acc->name == $entry->value) {
                    $result[$acc->name] = $acc->quantity;
                }
            }
        }
        return $result;
    }

    public static function isBikeDelivery($accessories) {
        foreach($accessories as $acc) {
            if (str_contains(strtolower($acc->name), 'delivery')) {
                return true;
            }
        }
        return false;
    }
}
