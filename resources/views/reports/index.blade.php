@extends('layout')
@section('content')
<h1 style="padding-bottom: 20px">Reports</h1>
<div class="reports-layout">
    <div class="reports-buttons">
        <a class="btn" href="/reports/revenueGraphs"><i class="fa-solid fa-dollar-sign" style="color:white"></i>Revenues</a> 
        <a class="btn" href="/reports/salesByLocation"><i class="fa-solid fa-location-dot" style="color:white"></i>Sales By Location</a>
        <a class="btn" href="/reports/graph"><i class="fas fa-chart-bar" style="color:white"></i>Assigned Bikes Graph</a>
        <a class="btn" href="/reports/bikesStatistics"><i class="fa-solid fa-bicycle" style="color:white"></i>Bike stats</a>
        <a class="btn" href="/orders/archive"><i class="fa-solid fa-book" style="color:white"></i>Order Archive</a>
        <a class="btn" href="/reports/bikeArchive"><i class="fa-solid fa-book" style="color:white"></i>Bike Archive</a>
        <a class="btn" href="/reports/statistics"><i class="fa-solid fa-chart-column" style="color:white"></i>Statistics</a>
        <a class="btn" href="/reports/bikeMaintenance"><i class="fas fa-tools" style="color:white"></i>Bike Maintenance</a>
    </div>
        <script>
            window.onload = function () {
             
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title:{
                    text: "<?php echo $chartTitle ?>"
                },
                axisX:{
                    interval: 200
                },
                axisY:{
                    includeZero: true,
                    margin: 200
                },
                legend:{
                    cursor: "pointer",
                    verticalAlign: "center",
                    horizontalAlign: "right",
                    itemclick: toggleDataSeries
                },
                data: [{
                    type: "column",
                    color: "purple",
                    name: "Revenue",
                    indexLabel: "",
                    yValueFormatString: "$#0.##",
                    showInLegend: true,
                    dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
                },]
            });
            chart.render();
             
            function toggleDataSeries(e){
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                }
                else{
                    e.dataSeries.visible = true;
                }
                chart.render();
            }
             
            }
            </script>
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
            <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        
   
    
    <div class="show-order">
        <div class="element">
            <table id="bike-figures-table" class="bike-figures-table clean-table" style="margin-bottom: 20px">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>Free</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalIn = 0;
                        $totalOut = 0;
                        $totalFree = 0;
                        $totalAll = 0;
                    @endphp
                    @foreach ($types as $bikeType)
                        <tr>
                            <td>{{$bikeType[0]->color}} {{$bikeType[0]->type}}</td>
                            @php
                                $ins = 0;
                                $outs = 0;
                                $frees = 0;
                                foreach ($bikeType as $bike) {
                                    if($bike->status == 'in') {
                                        $ins += 1;
                                    } else if($bike->status == 'out') {
                                        $outs += 1;
                                    } else if($bike->status == 'free') {
                                        $frees += 1;
                                    }
                                }
                            @endphp
                            <td>{{$ins}}</td>
                            <td>{{$outs}}</td>
                            <td>{{$frees}}</td>
                            <td>{{count($bikeType)}}</td>
                        </tr>
                        @php
                            $totalIn += $ins;
                            $totalOut += $outs;
                            $totalFree += $frees;
                            $totalAll += count($bikeType);
                        @endphp
                    @endforeach
                    <tr style="font-weight: bold">
                        <td>Total</td>
                        <td>{{$totalIn}}</td>
                        <td>{{$totalOut}}</td>
                        <td>{{$totalFree}}</td>
                        <td>{{$totalAll}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="element">
            <table class="clean-table">
                <thead>
                    <th>Location</th>
                    <th>In</th>
                    <th>Out</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach ($bikes as $bikesInLocation)
                    <tr>
                        @foreach ($bikesInLocation as $bikeStat)
                            <td>{{$bikeStat}}</td>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold">
                        <td>Total</td>
                        <td>{{$allIn}}</td>
                        <td>{{$allOut}}</td>
                        <td>{{$all}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="element">
            <h2>Sales</h2>
            <p>Today's sales: ${{$todaySales}}</p>
            <p>Week sales: ${{$weekSales}}</p>
            <p>Month's sales: ${{$monthSales}}</p>
            <p>Year sales: ${{$yearSales}}</p>
            <p>Total sales: ${{$totalSales}}</p>
            
        </div>
    </div>
</div>
  
@endsection