@extends('layout')

@section('content')

<div class="sorting-section-bike">
    <div class="filter-selector">
        <form method="GET" action="/bikes">
            <select name="filter" id="filter">
                <option selected="selected">{{$filter}}</option>
                @foreach ($categories as $item)
                    @if ($item == $filter)
                        {{-- Don't display duplicates --}}
                    @else
                        <option value={{$item}}>{{$item}} </option>
                    @endif
                @endforeach
                <option value="None">None</option>
            </select>
            <button type="submit">Go</button>
        </form>
    </div>
</div>

<table id="bikes-table" class="bikes-table">
    <thead>
    <tr>
        {{-- <th><input type="checkbox" onclick="toggleAllCheckbox2()"></th> --}}
        <th>Rack</th>
        <th>Color</th>
        <th>Type</th>
        <th>Code</th>
        <th>Location</th>
        <th>Status</th>
        <th>Order ID</th>
        <th>Name</th>
        <th>Assign</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
@php
    $even = false;
@endphp
@foreach ($bikes as $bike)
    <tbody>
        <tr @class([
            'bike-out' => ($bike['status'] == 'out' || $bike['status'] == 'Out'),
            'even' => $even == true,
            'bike-free' => $bike['status'] == 'free'
        ])>
            <td>{{$bike['rack']}}</td>
            <td>{{$bike['color']}}</td>
            <td>{{$bike['type']}}</td>
            <td><a href="/bikes/{{$bike['id']}}">{{$bike['code']}}</a></td>
            <td>{{$bike['location']}}</td>
            <td>{{$bike['status']}}</td>
            <td>{{$bike['dashboard_order_id']}}</td>
            <td>{{optional($bike->dashboardOrder)->first_name}}</td>
            <td>
                <a href="/bikes/{{$bike->id}}/assign">
                    <i class="fa-solid fa-bicycle" style="color: black">
                    </i>
                </a>
            </td>
            <td>
                <a href="/bikes/{{$bike->id}}/edit"><i class="fas fa-edit" style="color: #000000;"></i></a>            
            </td>
            <td>
                <form method="POST" action="/bikes/{{$bike->id}}">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Are you sure you want to delete this item?');"><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
                </form>
            </td>
        </tr>
    </tbody>
    @php
        if($even == true) {
            $even = false;
        } else {
            $even = true;
        }
    @endphp
@endforeach
</table>
<div class="container">
    <a class="btn" href="/bikes/add">Add Bike</a>
</div>
@endsection
