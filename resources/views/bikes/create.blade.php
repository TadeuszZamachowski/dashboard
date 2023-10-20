@extends('layout')

@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Add a bike</h1>
<form method="POST" action="/bikes/">
    @csrf
    <label for="color">Color:</label><br>
    <select name="color" id="color">
        <option value="{{old('color')}}" disabled selected>{{old('color')}}</option>
        <option value="Pink">Pink</option>
        <option value="Mint">Mint</option>
        <option value="Grey">Grey</option>
        <option value="Aqua">Aqua</option>
    </select><br>
    @error('color')
        <p>{{$message}}</p>
    @enderror

    <label for="type">Type:</label><br>
    <select name="type" id="type" >
        <option value="{{old('type')}}" disabled selected>{{old('type')}}</option>
        <option value="Cruiser">Cruiser</option>
        <option value="Urban">Urban</option>
        <option value="Kid">Kid</option>
    </select><br>
    @error('type')
        <p>{{$message}}</p>
    @enderror

    <label for="gear">Gear:</label><br>
    <select name="gear" id="gear">
        <option value="{{old('gear')}}" disabled selected>{{old('gear')}}</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select><br>
    @error('gear')
        <p>{{$message}}</p>
    @enderror

    <label for="accessory">Accessory:</label><br>
    <select name="accessory" id="accessory">
        <option value="{{old('accessory')}}" disabled selected>{{old('accessory')}}</option>
        @foreach ($accessories as $acc)
            <option value={{$acc->value}}>{{$acc->value}}</option>
        @endforeach
    </select><br>
    @error('accessory')
        <p>{{$message}}</p>
    @enderror

    <label for="code">Code:</label><br>
    <select name="code" id="code">
        <option value="{{old('code')}}" disabled selected>{{old('code')}}</option>
        @foreach ($codes as $code)
            <option value={{$code->value}}>{{$code->value}}</option>
        @endforeach
    </select><br>
    @error('code')
        <p>{{$message}}</p>
    @enderror

    <label for="location">Location:</label><br>
    <select name="location" id="location">
        <option value="{{old('location')}}" disabled selected>{{old('location')}}</option>
        @foreach ($locations as $loc)
            <option value={{$loc->value}}>{{$loc->value}}</option>
        @endforeach
    </select><br>
    @error('location')
        <p>{{$message}}</p>
    @enderror

    <label for="rack">Rack:</label><br>
    <select name="rack" id="rack">
        @for($i = 0; $i <= 39; $i++)
            <option value={{$i}}>{{$i}}</option>
        @endfor
    </select><br>
    @error('rack')
        <p>{{$message}}</p>
    @enderror

    <label for="status">Status:</label><br>
    <select name="status" id="status">
        <option value="{{old('status')}}" disabled selected>{{old('status')}}</option>
        <option value="in">In</option>
        <option value="out">Out</option>
    </select><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <input type="submit" value="Submit">
</form>


@endsection