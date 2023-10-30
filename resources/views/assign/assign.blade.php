@extends('layout')

@section('content')
<form method="POST" action="/assign/{{$order->dashboard_order_id}}">
    @csrf
    <h2>Number of bikes: {{$order->number_of_bikes}}</h2>
    <div class="assign">
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
    </div>
    {{-- last_url for redirecting to the appropraite page after edit --}}
    <input type="hidden" name="last_url" value="{{  URL::previous() }}">
    <input class="btn form-btn" type="submit" value="Submit">
</form>

@endsection