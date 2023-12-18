<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\DashboardOrderAccessory;
use Illuminate\Http\Request;

class AutomationController extends Controller
{
    public static function assign() { //fires every 2 minutes as a cron job
        
        $orders = DashboardOrder::where('order_status', 'LIKE', 'Processing')->get();
        $today = date('Y-m-d H:i');

        $output = "No orders";
        foreach($orders as $order) {
            $date = date('Y-m-d H:i',strtotime($order->start_date));
            $hourDiff = UtilController::getHours($today, $date);
            
            if($hourDiff <= 0.5) {
                $accessories = DashboardOrderAccessory::where('order_id', $order->dashboard_order_id)->get();
                $accessories = self::filterAccesssories($accessories); //excluding non physical attachements (like bike delivery etc.)
            }
        }

        return view('automationOutput', [
            'output' => $accessories
        ]);
    }

    public static function filterAccesssories($accessories) {
        $dictionary = array('Surfboard Rack', 'Basket', 'Front/Back lights', 'Child / Baby back seat', 'Kids Trailer');
        $result = array();

        foreach($accessories as $acc) {
            foreach($dictionary as $entry) {
                if ($acc->name == $entry) {
                    $result[] = $entry;
                }
            }
        }
        return $result;
    }
}
