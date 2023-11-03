@extends('layout')

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Add a bike</h1>
<form method="POST" action="/bikes">
    @csrf
    <div class="order-create">
        <div class="left-side">
            <label for="color">Color:</label>
            <select name="color" id="color">
                <option value="{{old('color')}}" disabled selected>{{old('color')}}</option>
                @foreach ($colors as $color)
                    <option value={{$color->value}}>{{$color->value}}</option>
                @endforeach
            </select>
            @error('color')
                <p>{{$message}}</p>
            @enderror

            <label for="type">Type:</label>
            <select name="type" id="type" >
                <option value="{{old('type')}}" disabled selected>{{old('type')}}</option>
                <option value="Cruiser">Cruiser</option>
                <option value="Urban">Urban</option>
                <option value="Kid">Kid</option>
            </select>
            @error('type')
                <p>{{$message}}</p>
            @enderror

            <label for="gear">Gear:</label>
            <select name="gear" id="gear">
                <option value="{{old('gear')}}" disabled selected>{{old('gear')}}</option>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
            @error('gear')
                <p>{{$message}}</p>
            @enderror

            <label for="accessory">Accessory:</label>
            <select name="accessory" id="accessory">
                <option value="{{old('accessory')}}" disabled selected>{{old('accessory')}}</option>
                @foreach ($accessories as $acc)
                    <option value={{$acc->value}}>{{$acc->value}}</option>
                @endforeach
            </select>
            @error('accessory')
                <p>{{$message}}</p>
            @enderror

            <label for="helmet">Helmet:</label>
            <select name="helmet" id="helmet">
                <option value="{{old('helmet')}}" disabled selected>{{old('helmet')}}</option>
                <option value="L">L</option>
                <option value="M">M</option>
                <option value="S">S</option>
            </select>
            @error('helmet')
                <p>{{$message}}</p>
            @enderror
        </div>
        <div class="right-side">
            <label for="code">Code:</label>
            <select name="code" id="code">
                <option value="{{old('code')}}" disabled selected>{{old('code')}}</option>
                @foreach ($codes as $code)
                    <option value={{$code->value}}>{{$code->value}}</option>
                @endforeach
            </select>
            @error('code')
                <p>{{$message}}</p>
            @enderror

            <label for="location">Location:</label>
            <select name="location" id="location">
                <option value="{{old('location')}}" disabled selected>{{old('location')}}</option>
                @foreach ($locations as $loc)
                    <option value={{$loc->value}}>{{$loc->value}}</option>
                @endforeach
            </select>
            @error('location')
                <p>{{$message}}</p>
            @enderror

            <label for="rack">Rack:</label>
            <select name="rack" id="rack">
                <option value="{{old('rack')}}" disabled selected>{{old('rack')}}</option>
                @foreach ($racks as $rack)
                    <option value={{$rack->value}}>{{$rack->value}}</option>
                @endforeach
            </select>
            @error('rack')
                <p>{{$message}}</p>
            @enderror

            <label for="state">State:</label>
            <select name="state" id="state">
                <option value="{{old('state')}}" disabled selected>{{old('state')}}</option>
                <option value="new">New</option>
                <option value="as new">As New</option>
                <option value="fair">Fair</option>
                <option value="repair">Repair</option>
            </select>
            @error('state')
                <p>{{$message}}</p>
            @enderror

            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="{{old('status')}}" disabled selected>{{old('status')}}</option>
                <option value="in">in</option>
                <option value="out">out</option>
                <option value="free">free</option>
            </select>
            @error('status')
                <p>{{$message}}</p>
            @enderror

            <label for="notes">Notes:</label>
            <input type="text" id="notes" name="notes" value="{{old('notes')}}">
            @error('notes')
                <p>{{$message}}</p>
            @enderror
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection