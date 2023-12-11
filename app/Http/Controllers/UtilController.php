<?php

namespace App\Http\Controllers;

use App\Models\Bike;
use App\Models\DashboardOrder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UtilController extends Controller
{
    public static function getTodaysSales() {
        $todaySales = 0;
        foreach(DashboardOrder::whereDate('created_at', Carbon::today())->get() as $order) {
            $todaySales += $order->amount_paid;
        }
        return $todaySales;
    }

    public static function getWeekSales() {
        $monday = date('Y-m-d',strtotime('monday this week'));
        $sunday = date("Y-m-d",strtotime("sunday this week"));
        $weekSales = 0;
        foreach(DashboardOrder::whereBetween('created_at', [$monday, $sunday])->get() as $order) {
            $weekSales += $order->amount_paid;
        }
        return $weekSales;
    }

    public static function getMonthSales() {
        $monthSales = 0;
        foreach(DashboardOrder::whereMonth('created_at', date('m'))->get() as $order) {
            $monthSales += $order->amount_paid;
        }
        return $monthSales;
    }

    public static function getYearSales() {
        $yearSales = 0;
        foreach(DashboardOrder::whereYear('created_at', date('Y'))->get() as $order) {
            $yearSales += $order->amount_paid;
        }
        return $yearSales;  
    }

    public static function getTotalSales() {
        $totalSales = 0;
        foreach(DashboardOrder::all() as $order) {
            $totalSales += $order->amount_paid;
        }
        return $totalSales;
    }

    public static function getBikeStats($locations) {
        $container = array();
        foreach($locations as $location) {
            $in = Bike::where('location', 'LIKE', '%'.$location->value.'%')->where('status', 'LIKE', 'in')->count();
            $out = Bike::where('location', 'LIKE', '%'.$location->value.'%')->where('status', 'LIKE', 'out')->count();
            $total = $in + $out;
            $bikesLocation = array($location->value, $in, $out, $total);
            $container[] = $bikesLocation;
        }
        return $container;
    }

    public static function getHours($date1, $date2) {//get number of hours between two dates
        $timestamp1 = strtotime($date1);
        $timestamp2 = strtotime($date2);
        
        $hour = ($timestamp2 - $timestamp1)/(60*60);
        return $hour;
        
    }
}
