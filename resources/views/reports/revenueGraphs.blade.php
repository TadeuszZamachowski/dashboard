@extends('layout')
@section('content')

<div class="order-create">
    <form method="GET" action="revenueGraph/result">

        <div class="input-section">
            <label for="location">Location:</label>
            <select name="location" id="location">
                @foreach ($locations as $location)
                    <option value="{{$location->value}}">{{$location->value}}</option>
                @endforeach
            </select>
            @error('location')
                <p>{{$message}}</p>
            @enderror
        </div>

        <div class="input-section">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" value="{{old('start_date')}}">
            @error('start_date')
                <p>{{$message}}</p>
            @enderror
        </div>

        <div class="input-section">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" value="{{old('end_date')}}">
            @error('end_date')
                <p>{{$message}}</p>
            @enderror
        </div>
        

        <input class="btn form-btn" type="submit" value="SUBMIT">
    </form>
</div>

@endsection