@extends('layout')
@section('content')

<div class="reports-index">
  
    <form method="GET" action="revenueGraph/result" class="reports-index">
        
        
        <input type="radio" id="Day" name="type_select" value="Day" checked="checked" onchange="changeInputType(this.value)">
        <label for="Day">Day</label> <br>
    
        <input type="radio" id="Week" name="type_select" value="Week" onchange="changeInputType(this.value)">
        <label for="Week">Week</label> <br>
    
        <input type="radio" id="Month" name="type_select" value="Month" onchange="changeInputType(this.value)">
        <label for="Month">Month</label> 
        
        
        <label for="location">Location:</label>
        <select name="location" id="location">
            @foreach ($locations as $location)
                <option value="{{$location->value}}">{{$location->value}}</option>
            @endforeach
        </select>
        @error('location')
            <p>{{$message}}</p>
        @enderror
    

    
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="{{old('start_date')}}" class="input-date">
        @error('start_date')
            <p>{{$message}}</p>
        @enderror
    

    
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="{{old('end_date')}}" class="input-date">
        @error('end_date')
            <p>{{$message}}</p>
        @enderror
        
        <input class="btn form-btn" type="submit" value="SUBMIT">
    </form>
</div>
<br>
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
            name: "Revenue",
            indexLabel: "{y}",
            yValueFormatString: "$#0.##",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
        },{
            type: "column",
            name: "Number of orders",
            indexLabel: "{y}",
            yValueFormatString: "#0.##",
            showInLegend: true,
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
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

@endsection