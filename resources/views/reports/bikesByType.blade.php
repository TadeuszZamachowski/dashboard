@extends('layout')
@section('content')
    <h1>Select bike details</h1>

    <div class="order-create">
        <form method="GET" action="bikesByType/result">

            <div class="input-section">
                <label for="type">Type:</label>
                <select name="type" id="type">
                    @foreach ($types as $type)
                        <option value="{{$type}}">{{$type}}</option>
                    @endforeach
                </select>
                @error('type')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="colour">Colour:</label>
                <select name="colour" id="colour">
                    @foreach ($colors as $color)
                        <option value="{{$color->value}}">{{$color->value}}</option>
                    @endforeach
                </select>
                @error('color')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <input class="btn form-btn" type="submit" value="SUBMIT">
        </form>
    </div>
@endsection