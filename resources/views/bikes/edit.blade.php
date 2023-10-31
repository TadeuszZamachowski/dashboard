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
    <div class="order-create">
        <div class="left-side">
            <label for="color">Color:</label><br>
            <select name="color" id="color">
                <option value="{{$bike->color}}" disabled selected>{{$bike->color}}</option>
                @foreach ($colors as $color)
                    <option value={{$color->value}}>{{$color->value}}</option>
                @endforeach
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
        </div>
        <div class="right-side">
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
                <option value="{{$bike->rack}}" disabled selected>{{$bike->rack}}</option>
                @foreach ($racks as $rack)
                    <option value={{$rack->value}}>{{$rack->value}}</option>
                @endforeach
            </select><br>
            @error('rack')
                <p>{{$message}}</p>
            @enderror

            <label for="status">Status:</label><br>
            <select name="status" id="status">
                <option value="{{$bike->status}}">{{$bike->status}}</option>
                <option value="in">in</option>
                <option value="out">out</option>
                <option value="free">free</option>
            </select><br>
            @error('status')
                <p>{{$message}}</p>
            @enderror
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection