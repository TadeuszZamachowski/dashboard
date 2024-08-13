<?php

namespace App\Http\Controllers;

use App\Models\DashboardOrder;
use App\Models\Location;
use App\Models\Bike;
use App\Models\BikesCheck;
use App\Models\BikeColor;
use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Http\Controllers\UtilController;
use DateTimeImmutable;

class ReportsController extends Controller
{
    public function index() {
        return view("reports.index");
    }

    public function salesByLocation() {
        return view("reports.salesByLocation", [
            'locations' => Location::all()
        ]);
    }

    public function process(Request $request) {
        $from = date("Y-m-d",strtotime($request->from));
        $to = date("Y-m-d",strtotime($request->to));
        $orders = DashboardOrder::whereBetween('created_at', [$from, $to])
                                ->where('pickup_location', 'LIKE', $request->location)->get();
        return view('reports.result', [
            'from' => $request->from,
            'to' => $request->to,
            'location' => $request->location,
            'orders' => $orders
        ]);
    }

    public function bikesStatistics() {
        $bikeTypes = ['Cruiser', 'Urban', 'Kid'];

        $overallBikes = array();
        foreach($bikeTypes as $type) {
            foreach(BikeColor::all() as $color) {
                $bikeFigures = Bike::where('type', 'LIKE', $type)->where('color','LIKE',$color['value'])
                ->where('status', 'NOT LIKE', 'sold')->get();
                if(count($bikeFigures) > 0) {
                    $overallBikes[] = $bikeFigures;
                }
            }
        }

        $soldBikes = array();
        foreach($bikeTypes as $type) {
            foreach(BikeColor::all() as $color) {
                $bikeFigures = Bike::where(function ($query) {
                    $query->where('status', 'LIKE', 'sold');
                })->where('type', 'LIKE', $type)
                  ->where('color','LIKE',$color['value'])
                  ->get();
                if(count($bikeFigures) > 0) {
                    $soldBikes[] = $bikeFigures;
                }
            }
        }

        return view('reports.bikesByTypeResult', [
            'locations' => Location::all(),
            'bikesSold' => Bike::where('status','LIKE', 'sold'),
            'colors' => BikeColor::all(),

            'overallBikes' => $overallBikes,
            'soldBikes' => $soldBikes

        ]);
    }

    public function graph() {
        $chart_options = [
            'chart_color' => '255,0,0',
            'chart_title' => 'Assigned bikes',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\BikeNumber',
            'group_by_field' => 'created_at',
            'group_by_period' => 'day',
            'aggregate_function' => 'sum',
            'aggregate_field' => 'count',
            'chart_type' => 'line',
        ];
        $chart1 = new LaravelChart($chart_options);
        
        return view('reports.graph', compact('chart1'));
    }

    public function revenueGraphs() {
        $start = new DateTimeImmutable(date("01-m-Y",strtotime(date("d-m-Y")))); // or your date as well
        $end = new DateTimeImmutable(date("t-m-Y",strtotime(date("d-m-Y"))));

        $dataPoints1 = array();
        $dataPoints2 = array();
        while($start <= $end) {
            $amount = DashboardOrder::whereDate('created_at', $start)->where('pickup_location', 'Mercato')->sum('amount_paid');
            $numberOfOrders = DashboardOrder::whereDate('created_at', $start)->where('pickup_location', 'Mercato')->count();

            array_push($dataPoints1, array("label"=> $start->format("d-m-Y"), "y"=> $amount));
            array_push($dataPoints2, array("label"=> $start->format("d-m-Y"), "y"=> $numberOfOrders));
            $start = $start->modify('+1 day');
        }
        
        $start = new DateTimeImmutable(date("01-m-Y",strtotime(date("d-m-Y"))));
        $chartTitle = "Mercato ". $start->format("d-m-Y") . " to " . $end->format("d-m-Y");

        return view('reports.revenueGraphs', [
            'locations' => Location::where('value', 'Bus Station')->orWhere('value', 'Mercato')->get(),

            'chartTitle' => $chartTitle,

            'dataPoints1' => $dataPoints1,
            'dataPoints2' => $dataPoints2
        ]);
    }

    public function displayRevenueGraph(Request $request) {
        $start = new DateTimeImmutable($request->start_date); // or your date as well
        $end = new DateTimeImmutable($request->end_date);

        $dataPoints1 = array();
        $dataPoints2 = array();
        if ($request->type_select == "Day") {
            while($start <= $end) {
                $amount = DashboardOrder::whereDate('created_at', $start)->where('pickup_location', $request->location)->sum('amount_paid');
                $numberOfOrders = DashboardOrder::whereDate('created_at', $start)->where('pickup_location', $request->location)->count();
    
                array_push($dataPoints1, array("label"=> $start->format("d-m-Y"), "y"=> $amount));
                array_push($dataPoints2, array("label"=> $start->format("d-m-Y"), "y"=> $numberOfOrders));
                $start = $start->modify('+1 day');
            }
        } else if($request->type_select == "Week") {
            while($start <= $end) {
                $weekFromNow = $start->modify('+1 week');
                $amount = DashboardOrder::whereBetween('created_at', [$start, $weekFromNow])->where('pickup_location', $request->location)->sum('amount_paid');
                $numberOfOrders = DashboardOrder::whereBetween('created_at', [$start, $weekFromNow])->where('pickup_location', $request->location)->count();
    
                array_push($dataPoints1, array("label"=> $start->format("d-m-Y") . " - " . $weekFromNow->format('d-m-Y'), "y"=> $amount));
                array_push($dataPoints2, array("label"=> $start->format("d-m-Y") . " - " . $weekFromNow->format('d-m-Y'), "y"=> $numberOfOrders));
                $start = $start->modify('+1 week');
            }
        } else if($request->type_select == "Month"){
            while($start <= $end) {
                $monthFromNow = $start->modify('+1 month');
                $amount = DashboardOrder::whereBetween('created_at', [$start, $monthFromNow])->where('pickup_location', $request->location)->sum('amount_paid');
                $numberOfOrders = DashboardOrder::whereBetween('created_at', [$start, $monthFromNow])->where('pickup_location', $request->location)->count();

                array_push($dataPoints1, array("label"=> $start->format("M"), "y"=> $amount));
                array_push($dataPoints2, array("label"=> $start->format("M"), "y"=> $numberOfOrders));
                $start = $start->modify('+1 month');
            }
        }
        
        $start = new DateTimeImmutable($request->start_date);
        $chartTitle = $request->location . " " . $start->format("d-m-Y") . " to " . $end->format("d-m-Y");

        return view('reports.showRevenueGraph', [
            'chartTitle' => $chartTitle,

            'dataPoints1' => $dataPoints1,
            'dataPoints2' => $dataPoints2
        ]);
    }

    public function statistics() {
        $chart_options = [
            'chart_color' => '219,112,147',
            'chart_title' => 'How did you hear about us?',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\DashboardOrder',
            'group_by_field' => 'address',
            'filter_field' => 'created_at',
            'range_date_start' => '2024-03-08 11:51:35',
            'range_date_end' => '2222-11-30 11:51:35',
            'chart_type' => 'bar',
        ];
        $chart1 = new LaravelChart($chart_options);

        $chart_options = [
            'chart_color' => '219,112,147',
            'chart_title' => 'Where do you stay in Byron?',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\DashboardOrder',
            'group_by_field' => 'accommodation',
            'filter_field' => 'created_at',
            'range_date_start' => '2024-03-08 11:51:35',
            'range_date_end' => '2222-11-30 11:51:35',
            'chart_type' => 'bar',
        ];
        $chart2 = new LaravelChart($chart_options);

        return view('reports.statistics', compact('chart1', 'chart2'));
    }

    public function bikeMaintenance() {
        $checks = BikesCheck::all();
        return view('reports.bikeMaintenance', [
            'checks' => $checks
        ]);
    }
}
