@extends('layout')

@section('content')
<form method="POST" action="/assign/{{$order->dashboard_order_id}}">
    @csrf
    <h1>Number of bikes: {{$order->number_of_bikes}}</h1>
    <label for="bike_id">Bike(s):</label><br>

    @for($i = 0; $i < $order->number_of_bikes; $i++)
    <select name="bike_ids[]" id="bike_ids">
        @foreach ($bikes as $bike)
            <option value="{{$bike->id}}">{{$bike->color}}, Code - {{$bike->code}}, Rack - {{$bike->rack}}</option>
        @endforeach
    </select>
    <br>
    @endfor

    <input type="submit" value="Submit">
</form>

@endsection