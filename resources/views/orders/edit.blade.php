@extends('layout')
@section('content')

<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Edit Order</h1>
<form method="POST" action="/orders/{{$order->dashboard_order_id}}">
    @csrf
    @method('PUT')
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" value="{{$order->first_name}}"><br>
    @error('first_name')
        <p>{{$message}}</p>
    @enderror

    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" value="{{$order->last_name}}"><br>
    @error('last_name')
        <p>{{$message}}</p>
    @enderror

    <label for="email">Email:</label><br>
    <input type="text" id="email" name="email" value="{{$order->email}}"><br>
    @error('email')
        <p>{{$message}}</p>
    @enderror

    <label for="mobile">Phone number:</label><br>
    <input type="text" id="mobile" name="mobile" value="{{$order->mobile}}"><br>
    @error('mobile')
        <p>{{$message}}</p>
    @enderror

    {{-- add date selector --}}
    <label for="start_date">Start Date:</label><br>
    <input type="text" id="start_date" name="start_date" value="{{$order->start_date}}"><br>
    @error('start_date')
        <p>{{$message}}</p>
    @enderror

    <label for="end_date">End Date:</label><br>
    <input type="text" id="end_date" name="end_date" value="{{$order->end_date}}"><br>
    @error('end_date')
        <p>{{$message}}</p>
    @enderror

    <label for="amount_paid">Amount Paid:</label><br>
    <input type="text" id="amount_paid" name="amount_paid" value="{{$order->amount_paid}}"><br>
    @error('amount_paid')
        <p>{{$message}}</p>
    @enderror

    {{-- add status selector --}}

    <label for="order_status">Status:</label><br>
    <select name="order_status" id="order_status">
        <option selected="selected">{{$order->order_status}}</option>
        @foreach ($categories as $item)
        <option value={{$item}}>  {{$item}} </option>
        @endforeach
    </select><br> 

    <label for="pickup_location">Pickup Location:</label><br>
    <input type="text" id="pickup_location" name="pickup_location" value="{{$order->pickup_location}}"><br>
    @error('pickup_location')
        <p>{{$message}}</p>
    @enderror

    <label for="number_of_bikes">Number of Bikes:</label><br>
    <input type="text" id="number_of_bikes" name="number_of_bikes" value="{{$order->number_of_bikes}}"><br>
    @error('number_of_bikes')
        <p>{{$message}}</p>
    @enderror

    {{-- unused fields: id, is_woo --}}

    <input type="submit" value="Submit">
</form>


@endsection