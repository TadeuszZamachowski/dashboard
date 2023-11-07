@extends('layout')

@section('content')

<div class="sorting-section">
    <div class="filter-selector">
        <form method="GET" action="/orders">
            <select onchange="this.form.submit()" name="filter" id="filter">
                <option selected="selected">{{$filter}}</option>
                @foreach ($categories as $item)
                    @if ($item == $filter || $item == 'Archived')
                        {{-- Don't display duplicates --}}
                    @else
                        <option value={{$item}}>  {{$item}} </option>
                    @endif
                @endforeach
                <option value="">None</option>
            </select>
        </form>
    </div>
    <div class="search-bar">
        <form method="GET" action="/orders">
            <input name="search" type="text" placeholder="Search.." value="{{$search}}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>

<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(0,0,1,0,1)">Order ID</th>
        <th onclick="sortTable(1,0,0,0,0)">Name</th>
        <th onclick="sortTable(2,0,0,0,1)">Phone number</th>
        <th onclick="sortTable(3,0,0,1,0)">Start Date</th>
        <th onclick="sortTable(4,0,0,0,1)">Duration (Days)</th>
        <th onclick="sortTable(5,0,0,0,1)">$</th>
        <th onclick="sortTable(6,0,0,1,0)">End Date</th>
        <th onclick="sortTable(7,1,0,0,0)">Status</th>
        <th onclick="sortTable(8,0,0,0,0)">Pickup</th>
        <th onclick="sortTable(9,0,0,0,1)">#</th>
        <th onclick="sortTable(10,0,0,0,1)" style="padding-right: 10px">Racks</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
@php
    $even = false;
@endphp
@foreach ($orders as $order)
    @php
        $frmtStartDate = date('d-m-Y',strtotime($order->start_date));
        $frmtEndDate = date('d-m-Y (g A)',strtotime($order->end_date));

        $date1 = new DateTime($order->start_date);
        $date2 = new DateTime($order->end_date);
        $interval = $date1->diff($date2);
        $duration = $interval->days;
    @endphp
    <tbody>
    <tr @class([
        'even' => $even == true,
        'due-date' => ($order->order_status == 'Processing') && (date('Y-m-d H:i:s', strtotime($order->end_date)) < date('Y-m-d H:i:s'))
    ])>
        <td>
            <div class="tooltip">
                <a href="/orders/{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}}</a>
                <span class="tooltiptext" style="width: 250px">
                    Start/End Time: {{date('H:i',strtotime($order->start_date))}}<br>
                    Email: {{$order->email}}<br>
                    Address: {{$order->address}}<br>
                    Payment Method: {{$order->payment_method}}
                </span>
            </div>
        </td>
        <td>{{$order->first_name}} {{$order->last_name}}</td>
        <td>{{$order->mobile}}</td>
        <td nowrap>{{$frmtStartDate}}</td>
        <td nowrap>{{$duration}}</td>
        <td>{{$order->amount_paid}}</td>
        <td nowrap>{{$frmtEndDate}}</td>
        <td>
            <div class="status-selector">
                <form method="POST" action="orders/status/{{$order->dashboard_order_id}}">
                    @csrf
                    @method('PUT')
                    <select onchange="this.form.submit()" name="order_status" id="order_status" @class([
                        'select-order-complete' => ($order->order_status == 'Completed' || $order->order_status == 'completed' || $order->order_status == 'wc-complete'),
                        'select-order-processing' => ($order->order_status == 'Processing' || $order->order_status == 'processing' || $order->order_status == 'wc-processing')
                    ])>
                        <option id="status_option" selected="selected">{{$order->order_status}}</option>
                        @foreach ($categories as $item)
                            @if ($item == $order->order_status)
                                {{-- Don't display duplicates --}}
                            @else
                                <option value={{$item}}>{{$item}} </option>
                            @endif
                        @endforeach
                    </select>
                </form>
            </div>
        </td>

        <td>{{$order->pickup_location}}</td>
        <td>{{$order->number_of_bikes}}</td>
        <td>
            @foreach ($order->bikes as $bike)
                |{{ $bike->rack }}|
            @endforeach 
        </td>
        <td>
            <div @class([
                'tooltip' => count($order->bikes) > 0
                ])>
                <a href="/orders/{{$order->dashboard_order_id}}/assign">
                    <i @class([
                        'fa-solid fa-bicycle bikes-assigned' => $order->bikes_assigned == 1,
                        'fa-solid fa-bicycle' => $order->bikes_assigned != 1])>
                    </i>
                </a>
                <span class="tooltiptext">
                    @if(count($order->bikes) > 0)
                        @foreach ($order->bikes as $bike)
                            Rack {{$bike->rack}} | Code: {{$bike->code}} <br>
                        @endforeach 
                    @endif
                </span>
            </div>
        </td>
        <td>
            <a href="/orders/{{$order->dashboard_order_id}}/edit"><i class="fas fa-edit"></i></a>
        </td>
        <td>
            <form method="POST" action="/orders/{{$order->dashboard_order_id}}">
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
<div class="pagination">
    {{ $orders->onEachSide(1)->links() }}
</div>
<a href="/orders/add" class="btn">Add Order</a>

@endsection

