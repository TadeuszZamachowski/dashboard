@extends('layout')

@section('content')
<style>
    table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {background-color: #5e1a1a;}
</style>
<table id="bikes-table" class="bikes-table">
    <thead>
    <tr>
        {{-- <th><input type="checkbox" onclick="toggleAllCheckbox2()"></th> --}}
        <th>Rack</th>
        <th>Color</th>
        <th>Type</th>
        <th>Gear</th>
        <th>Accessory</th>
        <th>Code</th>
        <th>Location</th>
        <th>Status</th>
        <th>Order ID</th>
        <th>Name</th>
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
            'even' => $even == true
        ])>
            <td>{{$bike['rack']}}</td>
            <td>{{$bike['color']}}</td>
            <td>{{$bike['type']}}</td>
            <td>{{$bike['gear']}}</td>
            <td>{{$bike['accessory']}}</td>
            <td><a href="/bikes/{{$bike['id']}}">{{$bike['code']}}</a></td>
            <td>{{$bike['location']}}</td>
            <td>{{$bike['status']}}</td>
            <td>{{$bike['dashboard_order_id']}}</td>
            <td>{{optional($bike->dashboardOrder)->first_name}}</td>
            <td>
                <a href="/bikes/{{$bike->id}}/edit"><i class="fas fa-edit" style="color: #000000;"></i></a>            
            </td>
            <td>
                <form method="POST" action="/bikes/{{$bike->id}}">
                    @csrf
                    @method('DELETE')
                    <button><i class="fa-solid fa-trash" style="color: #000000;"></i></button>
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
