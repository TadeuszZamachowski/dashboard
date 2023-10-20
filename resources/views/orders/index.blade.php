@extends('layout')

@section('content')

<table id="orders-table" class="orders-table">
    <thead>
    <tr>
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
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@foreach ($orders as $order)
    <tbody>
    <tr @class([
        'order-complete' => ($order->order_status == 'Completed' || $order->order_status == 'completed' || $order->order_status == 'wc-complete'),
        'order-processing' => ($order->order_status == 'Processing' || $order->order_status == 'processing' || $order->order_status == 'wc-processing')
    ])>
        <td>{{$order->dashboard_order_id}}</td>
        <td>{{$order->first_name}}</td>
        <td>{{$order->last_name}}</td>
        <td>{{$order->email}}</td>
        <td>{{$order->mobile}}</td>
        <?php $t = strtotime($order->start_date);   ?>
        <td>{{date('d-m-Y',$t)}}</td>
        <?php $t = strtotime($order->end_date);   ?>
        <td>{{date('d-m-Y',$t)}}</td>
        <td>{{"$".$order->amount_paid}}</td>
        <td>{{$order->order_status}}</td>
        <td>{{$order->pickup_location}}</td>
        <td>{{$order->number_of_bikes}}</td>
        <td><a href="/orders/{{$order->dashboard_order_id}}/assign">
            <i class="fa-solid fa-bicycle"></i></a>
        </td>
        <td>
            <a href="/orders/{{$order->dashboard_order_id}}/edit"><i class="fas fa-edit" style="color: #000000;"></i></a>
        </td>
        <td>
            <form method="POST" action="/orders/{{$order->dashboard_order_id}}">
                @csrf
                @method('DELETE')
                <button><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
            </form>
        </td>
        
    </tr>
    </tbody>

@endforeach
</table>
@endsection

