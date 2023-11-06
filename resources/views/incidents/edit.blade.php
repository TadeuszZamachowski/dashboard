@extends('layout')

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Add an incident</h1>
<form method="POST" action="/incidents/{{$incident->id}}">
    @csrf
    @method('PUT')
    <div class="order-create">
        <div class="left-side">
            <div class="input-section">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="{{$incident->date}}">
                @error('date')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="dashboard_order_id">Order:</label>
                <select name="dashboard_order_id" id="dashboard_order_id">
                    <option value="{{$incident->dashboard_order_id}}">{{$incident->dashboard_order_id}}</option>
                    @foreach ($orders as $order)
                        <option value={{$order->dashboard_order_id}}>{{$order->dashboard_order_id}} | {{$order->first_name}}</option>
                    @endforeach
                </select>
                @error('dashboard_order_id')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="bike_id">Bike:</label>
                <select name="bike_id" id="bike_id">
                    <option value="{{$incident->bike_id}}">{{$incident->bike_id}}</option>
                    @foreach ($bikes as $bike)
                        <option value={{$bike->id}}>Rack: {{$bike->rack}} | Code: {{$bike->code}}</option>
                    @endforeach
                </select>
                @error('bike_id')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="report">Report:</label>
                <textarea name="report" id="report" cols="30" rows="2">{{$incident->report}}</textarea>
                @error('report')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="action">Action:</label>
                <textarea name="action" id="action" cols="30" rows="2">{{$incident->action}}</textarea>
                @error('action')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection