@extends('layout')
@section('content')

<h1>DASHBOARD</h1>
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
@endsection