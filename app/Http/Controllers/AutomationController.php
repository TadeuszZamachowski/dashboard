<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\DashboardOrderAccessory;
use App\Models\Bike;
use App\Models\BikesDashboardOrder;
use App\Models\Accessory;
use App\Http\Controllers\SmsController;
use App\Models\DashboardAutomation;
use App\Services\TwilioService;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public static function assign() { //fires every 2 minutes as a cron job
        $setting = DashboardAutomation::first();
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
            
            if($hourDiff >= -5 && $hourDiff <= 0.5) { //start date is half an hour before or 5  hour after

                //excluding non physical attachements (like bike delivery etc.)
                $accessories = self::filterAccesssories(DashboardOrderAccessory::where('order_id', $order->dashboard_order_id)->get());
    
                $bikes = array();
                $accName = "";
                for($i = 0; $i < $order->number_of_bikes; $i++) {//iterating through number of bikes
                    foreach($accessories as $name => &$quantity) {
                        if($quantity >= 1) {
                            $accName = $name;//assigning current accessory name
                            $quantity -= 1;
                            break;//accessory found, breaking from foreach statement
                        }                           
                    }
                    $bike = Bike::where('accessory','LIKE',$accName)//looking for bike with the current accessory name
                                        ->where('status','LIKE','in')
                                        ->where('location','LIKE','Mercato')->first();
                    if(!$bike) {
                        $bike = Bike::where('accessory','LIKE','None')//bike with current accessory not found, taking one without an accessory
                                ->where('status','LIKE','in')
                                ->where('location','LIKE','Mercato')->first();
                    }
                    $bikes[] = $bike;

                    //creating history
                    $data['bike_id'] = $bike->id;
                    $data['order_id'] = $order->dashboard_order_id;
                    $data['start_date'] = $order->start_date;
                    $data['end_date'] = $order->end_date;
                    BikesDashboardOrder::create($data);

                    //assigning bikes to order
                    $bike->update(array(
                        'status' => 'out',
                        'dashboard_order_id' => $order->dashboard_order_id
                    ));

                    $order->update(array(
                        'order_status' => 'Assigned',
                        'bikes_assigned' => 1
                    ));
                }
                $sms = new SmsController(new TwilioService());
                $result = $sms->sendSMS($order->mobile, self::getMessage($bikes));

                if($result == 1) {
                    $output .= "Sent Sms to ". $order->dashboard_order_id. " ". $order->first_name." with bikes ";
                    foreach($bikes as $bike) {
                        $output .= ' | Rack: '. $bike->rack .' => Code: '.$bike->code;
                    }
                    $output .= "\r\n";
                } else {
                    //send email;
                    $output .= "Sent Email to ". $order->dashboard_order_id. " ". $order->first_name." with bikes ";
                    foreach($bikes as $bike) {
                        $output .= ' | Rack: '. $bike->rack .' => Code: '.$bike->code;
                    }
                    $output .= "\r\n";
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

    public static function getMessage($assignedBikes) {
        $message = 'Here are your rack numbers and codes: '. "\r\n";
        foreach($assignedBikes as $bike) {
            $message .= '=> Rack: '. $bike->rack .' | Code: '.$bike->code . "\r\n";
        }
        $message .= 'Please take a photo of the bike when picking it up and send it to +61 418 883 631. Upon return, hang the bike on the same bike rack. Attach the bike with the same lock code and send us a photo again.';
        return $message;   
    }
}
