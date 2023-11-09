@extends('layout')
@section('content')

<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Edit Order</h1>
@if ($order->bikes_assigned == 1 && ($order->order_status != "Completed" && $order->order_status != 'Archived'))
<div class="reassign" style="padding-top: 20px">
    <a class="btn" href="/orders/{{$order->dashboard_order_id}}/assign">Reassign bikes</a>
</div>
@endif
<form method="POST" action="/orders/{{$order->dashboard_order_id}}">
    @csrf
    @method('PUT')
    <div class="order-create">
        <div class="left-side">
            <div class="input-section">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="{{$order->first_name}}">
                @error('first_name')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="{{$order->last_name}}">
                @error('last_name')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="{{$order->email}}">
                @error('email')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="mobile">Phone number:</label>
                <input type="text" id="mobile" name="mobile" value="{{$order->mobile}}">
                @error('mobile')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
        <div class="right-side">
            <div class="input-section">
                <label for="start_date">Start Date:</label>
                <input type="datetime-local" id="start_date" name="start_date" value="{{strftime('%Y-%m-%dT%H:%M:%S', strtotime($order->start_date))}}">
                @error('start_date')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="end_date">End Date:</label>
                <input type="datetime-local" id="end_date" name="end_date" value="{{strftime('%Y-%m-%dT%H:%M:%S', strtotime($order->end_date))}}">
                @error('end_date')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="amount_paid">Amount Paid:</label>
                <input type="text" id="amount_paid" name="amount_paid" value="{{$order->amount_paid}}">
                @error('amount_paid')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="payment_method">Payment Method:</label>
                <select name="payment_method" id="payment_method">
                    <option value="{{$order->payment_method}}">{{$order->payment_method}}</option>
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
                <label for="order_status">Status:</label>
                <select name="order_status" id="order_status">
                    <option selected="selected">{{$order->order_status}}</option>
                    @foreach ($categories as $item)
                        @if ($item == $order->order_status)
                            {{-- Don't display duplicates --}}
                        @else
                            <option value={{$item}}>  {{$item}} </option>
                        @endif
                    @endforeach
                </select>
            </div>
            <br>

            <div class="input-section">
                <label for="pickup_location">Pickup Location:</label>
                <input type="text" id="pickup_location" name="pickup_location" value="{{$order->pickup_location}}">
                @error('pickup_location')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{$order->address}}">
                @error('address')
                    <p>{{$message}}</p>
                @enderror
            </div>
            <br>

            <div class="input-section">
                <label for="number_of_bikes">Number of Bikes:</label>
                <input type="text" id="number_of_bikes" name="number_of_bikes" value="{{$order->number_of_bikes}}">
                @error('number_of_bikes')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
    </div>
    {{-- last_url for redirecting to the appropraite page after edit --}}
    <input type="hidden" name="last_url" value="{{  URL::previous() }}">
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection