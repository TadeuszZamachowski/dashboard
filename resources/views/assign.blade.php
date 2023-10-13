@extends('layout')
@extends('orders.side-order')

@section('content')
<form method="POST" action="/assign">
    @csrf
    <label for="order_id">Order ID:</label><br>
    <input type="text" id="order_id" name="order_id" value="{{old('order_id')}}"><br>
    @error('order_id')
        <p>{{$message}}</p>
    @enderror

    <label for="bike_id">Bike ID:</label><br>
    <input type="text" id="bike_id" name="bike_id" value="{{old('bike_id')}}"><br>
    @error('bike_id')
        <p>{{$message}}</p>
    @enderror

    <input type="submit" value="Submit">
</form>

@endsection