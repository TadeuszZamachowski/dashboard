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

<table id="orders-table" class="bikes-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(0,0,0,0,1)">Rack</th>
        <th onclick="sortTable(1,0,0,0,0)">Color</th>
        <th onclick="sortTable(2,0,0,0,0)">Type</th>
        <th onclick="sortTable(3,0,0,0,0)">Accessory</th>
        <th onclick="sortTable(4,0,1,0,1)">Code</th>
        <th onclick="sortTable(5,0,0,0,0)">Location</th>
        <th onclick="sortTable(6,0,0,0,0)">Status</th>
        <th onclick="sortTable(7,0,0,0,1)">Order ID</th>
        <th onclick="sortTable(8,0,0,0,0)">Name</th>
        <th onclick="sortTable(9,0,0,1,0)">Return Date</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@foreach ($bikes as $bike)
    <tbody>
        <tr @class([
            'bike-in' => ($bike['status'] == 'in' || $bike['status'] == 'In'),
            'bike-out' => ($bike['status'] == 'out' || $bike['status'] == 'Out'),
            'bike-free' => $bike['status'] == 'free'
        ])>
            <td>{{$bike['rack']}}</td>
            <td>{{$bike['color']}}</td>
            <td>{{$bike['type']}}</td>
            <td>{{$bike['accessory']}}</td>
            <td><a href="/bikes/{{$bike['id']}}">{{$bike['code']}}</a></td>
            <td>{{$bike['location']}}</td>
            <td>{{$bike['status']}}</td>
            <td>
                <a href="orders/{{$bike['dashboard_order_id']}}">
                    {{$bike['dashboard_order_id']}}</a></td>
            <td>{{optional($bike->dashboardOrder)->first_name}}</td>
            @php
                $date = optional($bike->dashboardOrder)->end_date;
                if($date != null) {
                  $frmtDate = date('d-m-Y',strtotime($date));
                } else {
                  $frmtDate = "";
                }
            @endphp
            <td>{{$frmtDate}}</td>
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
    {{-- Black stripe after rack 15 --}}
    @if($bike->rack == 15) 
        <tr style="background-color: black;">
            @for ($i = 13; $i > 0; $i--)
                <td>.</td>
            @endfor
        </tr>
    @endif
@endforeach
</table>
<div class="container">
    <a class="btn" href="/bikes/add">Add Bike</a>
</div>
@endsection
