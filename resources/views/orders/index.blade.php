@extends('layout')

@section('content')
<style>
    .selector {
        background-color: antiquewhite;
    }
</style>
<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        <th>Order ID</th>
        <th>Name</th>
        <th>Phone number</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Pickup</th>
        <th style="padding-right: 10px">Bikes</th>
        <th>Assign</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
@php
    $even = false;
@endphp
@foreach ($orders as $order)
    <tbody>
    <tr @class([
        'order-complete' => ($order->order_status == 'Completed' || $order->order_status == 'completed' || $order->order_status == 'wc-complete'),
        'order-processing' => ($order->order_status == 'Processing' || $order->order_status == 'processing' || $order->order_status == 'wc-processing'),
        'even' => $even == true
    ])>
        <td><a href="/orders/{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}}</a></td>
        <td>{{$order->first_name}} {{$order->last_name}}</td>
        <td>{{$order->mobile}}</td>
        <?php $t = strtotime($order->start_date);   ?>
        <td nowrap>{{date('d-m-Y',$t)}}</td>
        <?php $t = strtotime($order->end_date);   ?>
        <td nowrap>{{date('d-m-Y',$t)}}</td>
        <td>{{"$".$order->amount_paid}}</td>

        <td>
            <div class="status-selector">
                <form method="POST" action="orders/status/{{$order->dashboard_order_id}}">
                    @csrf
                    @method('PUT')
                    <select name="order_status" id="order_status" @class([
                        'select-order-complete' => ($order->order_status == 'Completed' || $order->order_status == 'completed' || $order->order_status == 'wc-complete'),
                        'select-order-processing' => ($order->order_status == 'Processing' || $order->order_status == 'processing' || $order->order_status == 'wc-processing')
                    ])>
                        <option selected="selected">{{$order->order_status}}</option>
                        @foreach ($categories as $item)
                            <option value={{$item}}>  {{$item}} </option>
                        @endforeach
                    </select>
                    <button type="submit">
                    <i class="fas fa-save"></i>
                    </button>
                </form>
            </div>
        </td>

        <td>{{$order->pickup_location}}</td>
        <td>{{$order->number_of_bikes}}</td>
        <td><a href="/orders/{{$order->dashboard_order_id}}/assign">
            <i class="fa-solid fa-bicycle"></i></a>
        </td>
        <td>
            <a href="/orders/{{$order->dashboard_order_id}}/edit"><i class="fas fa-edit"></i></a>
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
    @php
        if($even == true) {
            $even = false;
        } else {
            $even = true;
        }
    @endphp
@endforeach
</table>
@endsection

