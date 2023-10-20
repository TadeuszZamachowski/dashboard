@extends('layout')


@section('content')
<style>
    p {
        color: red;
        font-size: 12px;
    }
</style>
<h1>Edit bike</h1>
<form method="POST" action="/bikes/{{$bike->id}}">
    @csrf
    @method('PUT')
    <label for="color">Color:</label><br>
    <select name="color" id="color">
        <option value="{{$bike->color}}">{{$bike->color}}</option>
        <option value="Pink">Pink</option>
        <option value="Mint">Mint</option>
        <option value="Grey">Grey</option>
        <option value="Aqua">Aqua</option>
        <option value="White">White</option>
    </select><br>
    @error('color')
        <p>{{$message}}</p>
    @enderror

    <label for="type">Type:</label><br>
    <select name="type" id="type" >
        <option value="{{$bike->type}}">{{$bike->type}}</option>
        <option value="Cruiser">Cruiser</option>
        <option value="Urban">Urban</option>
        <option value="Kid">Kid</option>
    </select><br>
    @error('type')
        <p>{{$message}}</p>
    @enderror

    <label for="gear">Gear:</label><br>
    <select name="gear" id="gear">
        <option value="{{$bike->gear}}">{{$bike->gear}}</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select><br>
    @error('gear')
        <p>{{$message}}</p>
    @enderror

    <label for="accessory">Accessory:</label><br>
    <select name="accessory" id="accessory">
        <option value="{{$bike->accessory}}">{{$bike->accessory}}</option>
        @foreach ($accessories as $acc)
            <option value={{$acc->value}}>{{$acc->value}}</option>
        @endforeach
    </select><br>
    @error('accessory')
        <p>{{$message}}</p>
    @enderror

    <label for="code">Code:</label><br>
    <select name="code" id="code">
        <option value="{{$bike->code}}">{{$bike->code}}</option>
        @foreach ($codes as $code)
            <option value={{$code->value}}>{{$code->value}}</option>
        @endforeach
    </select><br>
    @error('code')
        <p>{{$message}}</p>
    @enderror

    <label for="location">Location:</label><br>
    <select name="location" id="location">
        <option value="{{$bike->location}}">{{$bike->location}}</option>
        @foreach ($locations as $loc)
            <option value={{$loc->value}}>{{$loc->value}}</option>
        @endforeach
    </select><br>
    @error('location')
        <p>{{$message}}</p>
    @enderror

    <label for="rack">Rack:</label><br>
    <select name="rack" id="rack">
        <option value={{$bike->rack}}>{{$bike->rack}}</option>
        @for($i = 0; $i <= 39; $i++)
            <option value={{$i}}>{{$i}}</option>
        @endfor
    </select><br>
    @error('rack')
        <p>{{$message}}</p>
    @enderror

    <label for="status">Status:</label><br>
    <select name="status" id="status">
        <option value="{{$bike->status}}">{{$bike->status}}</option>
        <option value="in">In</option>
        <option value="out">Out</option>
    </select><br>
    @error('status')
        <p>{{$message}}</p>
    @enderror

    <input type="submit" value="Submit">
</form>
@endsection