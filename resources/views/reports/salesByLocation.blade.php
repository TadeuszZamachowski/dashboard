@extends('layout')
@section('content')
    <h1>Select orders details</h1>

    <div class="order-create">
        <form method="GET" action="salesByLocation/result">

            <div class="input-section">
                <label for="from">From:</label>
                <input type="date" id="from" name="from">
                @error('from')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="to">To:</label>
                <input type="date" id="to" name="to">
                @error('to')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="location">Location:</label>
                <select name="location" id="location">
                    @foreach ($locations as $location)
                        <option value="{{$location->value}}">{{$location->value}}</option>
                    @endforeach
                </select>
                @error('to')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>
            <input class="btn form-btn" type="submit" value="SUBMIT">
        </form>
    </div>
@endsection