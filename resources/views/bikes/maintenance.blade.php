@extends('layout')  
@section('content')
<form method="POST" action="/bikes/check">
    @csrf
    <div class="order-create">
        <input type="hidden" name="bike_id" value="{{$bike_id}}">
        <div class="left-side">

            <div class="input-section">
                <label for="work">Work done:</label>
                <select name="work" id="work">
                    <option value="{{old('work')}}">{{old('work')}}</option>
                    <option value="clean brakes">Clean Brakes</option>
                    <option value="clean wheel">Clean Wheel</option>
                    <option value="clean chain">Clean chain</option>
                </select>
                @error('work')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="rust">Rust:</label>
                <select name="rust" id="rust">
                    <option value="{{old('rust')}}">{{old('rust')}}</option>
                    <option value="good">Good</option>
                    <option value="average">Average</option>
                    <option value="bad">Bad</option>
                </select>
                @error('rust')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="brakes">Brakes:</label>
                <select name="brakes" id="brakes">
                    <option value="{{old('brakes')}}">{{old('brakes')}}</option>
                    <option value="good">Good</option>
                    <option value="average">Average</option>
                    <option value="bad">Bad</option>
                </select>
                @error('brakes')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>

        <div class="right-side">

            <div class="input-section">
                <label for="wheels">Wheels:</label>
                <select name="wheels" id="wheels">
                    <option value="{{old('wheels')}}">{{old('wheels')}}</option>
                    <option value="good">Good</option>
                    <option value="average">Average</option>
                    <option value="bad">Bad</option>
                </select>
                @error('wheels')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="chain">Chain:</label>
                <select name="chain" id="chain">
                    <option value="{{old('chain')}}">{{old('chain')}}</option>
                    <option value="good">Good</option>
                    <option value="average">Average</option>
                    <option value="bad">Bad</option>
                </select>
                @error('chain')
                    <p>{{$message}}</p>
                @enderror
            </div>

            <div class="input-section">
                <label for="notes">Notes:</label>
                <input type="text" id="notes" name="notes" value="{{old('notes')}}">
                @error('notes')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection