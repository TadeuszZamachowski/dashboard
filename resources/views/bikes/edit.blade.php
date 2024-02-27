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

            <div class="input-section">
                <label for="number">Number:</label>
                <select name="number" id="number">
                    <option value="{{$bike->number}}">{{$bike->number}}</option>
                    @for ($i = 1; $i <= 40; $i++)
                        <option value={{$i}}>{{$i}}</option>
                    @endfor
                </select>
                @error('number')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="rack">Rack:</label>
                <select name="rack" id="rack">
                    <option value="{{$bike->rack}}">{{$bike->rack}}</option>
                    @for ($i = 1; $i <= 40; $i++)
                        <option value={{$i}}>{{$i}}</option>
                    @endfor
                </select>
                @error('rack')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="color">Color:</label>
                <select name="color" id="color">
                    <option value="{{$bike->color}}">{{$bike->color}}</option>
                    @foreach ($colors as $color)
                        <option value={{$color->value}}>{{$color->value}}</option>
                    @endforeach
                </select>
                @error('color')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="type">Type:</label>
                <select name="type" id="type" >
                    <option value="{{$bike->type}}">{{$bike->type}}</option>
                    <option value="Cruiser">Cruiser</option>
                    <option value="Urban">Urban</option>
                    <option value="Kid">Kid</option>
                </select>
                @error('type')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="gear">Gear:</label>
                <select name="gear" id="gear">
                    <option value="{{$bike->gear}}">{{$bike->gear}}</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
                @error('gear')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="accessory">Accessory:</label>
                <select name="accessory" id="accessory">
                    <option value="{{$bike->accessory}}">{{$bike->accessory}}</option>
                    @foreach ($accessories as $acc)
                        <option value="{{$acc->value}}">{{$acc->value}}</option>
                    @endforeach
                </select>
                @error('accessory')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="helmet">Helmet:</label>
                <select name="helmet" id="helmet">
                    <option value="{{$bike->helmet}}">{{$bike->helmet}}</option>
                    <option value="L">L</option>
                    <option value="M">M</option>
                    <option value="S">S</option>
                </select>
                @error('helmet')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
        <div class="right-side">

            <div class="input-section">
                <label for="code">Code:</label>
                <select name="code" id="code">
                    <option value="{{$bike->code}}">{{$bike->code}}</option>
                    @foreach ($codes as $code)
                        <option value={{$code->value}}>{{$code->value}}</option>
                    @endforeach
                </select>
                @error('code')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="location">Location:</label>
                <select name="location" id="location">
                    <option value="{{$bike->location}}">{{$bike->location}}</option>
                    @foreach ($locations as $loc)
                        <option value={{$loc->value}}>{{$loc->value}}</option>
                    @endforeach
                </select>
                @error('location')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="state">State:</label>
                <select name="state" id="state">
                    <option value="{{$bike->state}}">{{$bike->state}}</option>
                    <option value="new">New</option>
                    <option value="as new">As New</option>
                    <option value="fair">Fair</option>
                    <option value="repair">Repair</option>
                </select>
                @error('state')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="{{$bike->status}}">{{$bike->status}}</option>
                    <option value="in">in</option>
                    <option value="out">out</option>
                    <option value="free">free</option>
                    <option value="sell">sell</option>
                    <option value="archive">archive</option>
                </select>
                @error('status')
                    <p>{{$message}}</p>
                @enderror
                <br>
            </div>

            <div class="input-section">
                <label for="notes">Notes:</label>
                <input type="text" id="notes" name="notes" value="{{$bike->notes}}"><br>
                @error('notes')
                    <p>{{$message}}</p>
                @enderror
            </div>
        </div>
    </div>
    <input class="btn form-btn" type="submit" value="Submit">
</form>
@endsection