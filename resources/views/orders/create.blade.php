@extends('layout')

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Add Order</h1>
<form method="POST" action="/orders">
    @csrf
    <div class="order-create">
        <div class="left-side">
            <div class="input-section">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="{{old('first_name')}}">
                @error('first_name')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="{{old('last_name')}}">
                @error('last_name')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="{{old('email')}}">
                @error('email')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="mobile">Phone number:</label>
                <input type="text" id="mobile" name="mobile" value="{{old('mobile')}}">
                @error('mobile')
                    <p>{{$message}}</p>
                @enderror
            </div>

            <div class="input-section">
                <label for="accommodation">Accommodation:</label>
                <select name="accommodation" id="accommodation">
                    <option selected="selected">{{old('accommodation')}}</option>
                    @foreach ($accommodations as $acc)
                        <option value={{$acc->value}}>{{$acc->value}} </option>
                    @endforeach
                </select>
                @error('accommodation')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
        <div class="right-side">

            <div class="input-section">
                <label for="start_date">Start Date:</label>
                <input type="datetime-local" id="start_date" name="start_date" value="{{old('start_date')}}">
                @error('start_date')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="end_date">End Date:</label>
                <input type="datetime-local" id="end_date" name="end_date" value="{{old('end_date')}}">
                @error('end_date')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="amount_paid">Amount Paid:</label>
                <input type="text" id="amount_paid" name="amount_paid" value="{{old('amount_paid')}}">
                @error('amount_paid')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method">
                    <option value="{{old('payment_method')}}">{{old('payment_method')}}</option>
                    <option value="bacs">Bank Transfer</option>
                    <option value="cc">Credit Card</option>
                    <option value="pp">PayPal</option>
                    <option value="ap">AfterPay</option>
                </select>
                @error('payment_method')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="pickup_location">Location:</label>
                <select name="pickup_location" id="pickup_location">
                    <option value="{{old('pickup_location')}}">{{old('pickup_location')}}</option>
                    @foreach ($locations as $loc)
                        <option value={{$loc->value}}>{{$loc->value}}</option>
                    @endforeach
                </select>
                @error('pickup_location')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="address">How did you hear about us?:</label>
                <select name="address" id="address">
                    <option value="{{old('address')}}">{{old('address')}}</option>
                    <option value="Bus stop sign">Bus stop sign</option>
                    <option value="Flyers">Flyers</option>
                    <option value="Online search">Online search</option>
                    <option value="Onsite sign - Woolworth">Onsite sign - Woolworth</option>
                </select>
                @error('address')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="number_of_bikes">Number of Bikes:</label>
                <input type="text" id="number_of_bikes" name="number_of_bikes" value="{{old('number_of_bikes')}}">
                @error('number_of_bikes')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="SUBMIT">
</form>
@endsection