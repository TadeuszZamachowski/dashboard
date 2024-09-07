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