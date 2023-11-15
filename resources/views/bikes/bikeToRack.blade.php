@extends('layout')
@section('content')
<h1>Add Bike To Rack</h1>
<form method="POST" action="/bikes/boundToRack/{{$rack->id}}">
    @csrf
    <div class="assign">
        <label for="bike_id">Bikes:</label><br>
        <select name="bike_id" id="bike_id">
            @foreach ($bikes as $bike)
                <option value="{{$bike->id}}">ID - {{$bike->id}} | Code - {{$bike->code}} | {{$bike->color}} {{$bike->type}}</option>
            @endforeach
        </select>
    </div>
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection