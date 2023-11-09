@extends('layout')
@section('content')

<h1>DASHBOARD</h1>

<div class="show-order">
    <div class="element">
        <table>
            <thead> <h2>Bikes</h2>
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
        {{-- @foreach ($orders as $order)
            {{$order->first_name}}
        @endforeach
        {{count($orders)}} --}}
        
    </div>
</div>
@endsection