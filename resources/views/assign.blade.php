@extends('layout')

@section('content')
<form method="POST" action="/assign/{{$order->dashboard_order_id}}">
    @csrf
    <h1>Number of bikes: {{$order->number_of_bikes}}</h1>
    <label for="bike_id">Bike(s):</label><br>

    @php
        $counter = 0;
    @endphp
    {{-- Counter for jumping to next bikes when populating options to choose from --}}
    @for($i = 0; $i < $order->number_of_bikes; $i++)
    <select name="bike_ids[]" id="bike_ids">
        @for($j = $counter; $j < count($bikes); $j++)
            <option value="{{$bikes[$j]->id}}">{{$bikes[$j]->color}}, Code - {{$bikes[$j]->code}}, Rack - {{$bikes[$j]->rack}}</option>
        @endfor
    </select>
    <br>
    @php
        $counter += 1;
    @endphp
    @endfor

    <input type="submit" value="Submit">
</form>

@endsection