@extends('layout')

@section('content')
<table id="dashboard-orders" class="row-border dashboard" style="margin-bottom:20px">
    <thead>
    <tr>
        {{-- <th><input type="checkbox" onclick="toggleAllCheckbox2()"></th> --}}
        <th>ID</th>
        <th>Color</th>
        <th>Type</th>
        <th>Gear</th>
        <th>Accessory</th>
        <th>Code</th>
        <th>Location</th>
        <th>Rack</th>
        <th>Status</th>
        <th>Order ID</th>
        <th>Name</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
@foreach ($bikes as $bike)
<tbody>
    <tr>
        {{-- <td><input type="checkbox" name="order_id" value={{$bike['id']}}></td> --}}
        <td><a href="/bikes/{{$bike['id']}}">{{$bike['id']}}</td>
        <td>{{$bike['color']}}</td>
        <td>{{$bike['type']}}</td>
        <td>{{$bike['gear']}}</td>
        <td>{{$bike['accessory']}}</td>
        <td>{{$bike['code']}}</td>
        <td>{{$bike['location']}}</td>
        <td>{{$bike['rack']}}</td>
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
@endforeach

@endsection
