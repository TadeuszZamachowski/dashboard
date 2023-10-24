@extends('layout')

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Add Order</h1>
<form method="POST" action="/">
    @csrf
    <div class="order-create">
        <div class="left-side">
            <label for="first_name">First Name:</label><br>
            <input type="text" id="first_name" name="first_name" value="{{old('first_name')}}"><br>
            @error('first_name')
                <p>{{$message}}</p>
            @enderror

            <label for="last_name">Last Name:</label><br>
            <input type="text" id="last_name" name="last_name" value="{{old('last_name')}}"><br>
            @error('last_name')
                <p>{{$message}}</p>
            @enderror

            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" value="{{old('email')}}"><br>
            @error('email')
                <p>{{$message}}</p>
            @enderror

            <label for="mobile">Phone number:</label><br>
            <input type="text" id="mobile" name="mobile" value="{{old('mobile')}}"><br>
            @error('mobile')
                <p>{{$message}}</p>
            @enderror
        </div>
        <div class="right-side">
            <label for="start_date">Start Date:</label><br>
            <input type="datetime-local" id="start_date" name="start_date" value="{{old('start_date')}}"><br>
            @error('start_date')
                <p>{{$message}}</p>
            @enderror

            <label for="end_date">End Date:</label><br>
            <input type="datetime-local" id="end_date" name="end_date" value="{{old('end_date')}}"><br>
            @error('end_date')
                <p>{{$message}}</p>
            @enderror

            <label for="amount_paid">Amount Paid:</label><br>
            <input type="text" id="amount_paid" name="amount_paid" value="{{old('amount_paid')}}"><br>
            @error('amount_paid')
                <p>{{$message}}</p>
            @enderror

            <label for="pickup_location">Pickup Location:</label><br>
            <input type="text" id="pickup_location" name="pickup_location" value="{{old('pickup_location')}}"><br>
            @error('pickup_location')
                <p>{{$message}}</p>
            @enderror

            <label for="number_of_bikes">Number of Bikes:</label><br>
            <input type="text" id="number_of_bikes" name="number_of_bikes" value="{{old('number_of_bikes')}}"><br>
            @error('number_of_bikes')
                <p>{{$message}}</p>
            @enderror
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="SUBMIT">
</form>

@endsection