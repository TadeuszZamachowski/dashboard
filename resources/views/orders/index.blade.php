@extends('layout')
@extends('orders.side-order')

@section('content')


<table id="dashboard-orders" class="row-border dashboard" style="margin-bottom:20px">
    <thead>
    <tr>
        <th><input type="checkbox" onclick="toggleAllCheckbox2()"></th>
        <th>Order ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone number</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Amount Paid</th>
        <th>Status</th>
        <th>Pickup Location</th>
        <th>Number of bikes</th>
    </tr>
    </thead>
@foreach ($orders as $order)
    <tbody>
    <tr>
        <td>
            <input type="checkbox" name="order_id" value="">
        </td>
        <td><a href="/orders/{{$order->id}}">{{$order->id}}</a></td>
        <td>{{$order->first_name}}</td>
        <td>{{$order->last_name}}</td>
        <td>{{$order->email}}</td>
        <td>{{$order->mobile}}</td>
        <td>{{$order->start_date}}</td>
        <td>{{$order->end_date}}</td>
        <td>{{$order->amount_paid. " $"}}</td>
        <td>{{$order->order_status}}</td>
        <td>{{$order->pickup_location}}</td>
        <td>{{$order->number_of_bikes}}</td>
    </tr>
    </tbody>
    

@endforeach
@endsection

