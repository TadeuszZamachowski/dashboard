@extends('layout')

@section('content')

<div class="sorting-section">
    <div class="filter-selector">
        <form method="GET" action="/">
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
        <div class="process" style="padding-right: 20px">
            Processing = {{$processing}}
        </div>
        <div class="ass" style="padding-right: 20px">
            Assigned = {{$assigned}}
        </div>
        <form method="GET" action="/">
            <input name="search" type="text" placeholder="Search.." value="{{$search}}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>

<a href="/orders/add" class="btn">Add Order</a>
<a href="/orders/add-quick" class="btn">Add Quick Order</a>
<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(0,0,1,0,1)">Order ID</th>
        <th onclick="sortTable(1,0,0,0,0)">Name</th>
        <th onclick="sortTable(2,1,0,0,0)">Status</th>
        <th onclick="sortTable(3,0,0,0,1)" style="padding-right: 10px" nowrap >Rack | Code</th>
        <th onclick="sortTable(4,0,0,0,1)">Phone number</th>
        <th onclick="sortTable(5,0,0,0,0)">Acc</th>
        <th onclick="sortTable(6,0,0,1,0)">Start Date</th>
        <th onclick="sortTable(7,0,0,0,1)">Duration</th>
        <th onclick="sortTable(8,0,0,1,0)">End Date</th>
        <th onclick="sortTable(9,0,0,0,1)"># Bikes</th>
        <th onclick="sortTable(10,0,0,0,1)">$</th>
        <th onclick="sortTable(11,0,0,0,0)">Pickup</th>
        <th></th>
        <th></th>
        <th>Pre-Pickup SMS</th>
        <th>Reminder SMS</th>
    </tr>
    </thead>
    @php
        $ordersWeekFromNow = array();
    @endphp
@foreach ($orders as $order)
    @php
        $today = new DateTime();
        $startDateTime = new DateTime(date('d-m-Y',strtotime($order->start_date)));
        $difference = $today->diff($startDateTime);

        if($difference->days >= 7 && $startDateTime > $today) {
            $ordersWeekFromNow[] = $order;
            continue;
        }


        $frmtStartDate = date('d-m-Y (g A)',strtotime($order->start_date));
        $frmtEndDate = date('d-m-Y (g A)',strtotime($order->end_date));

        $date1 = new DateTime($order->start_date);
        $date2 = new DateTime($order->end_date);
        $interval = $date1->diff($date2);
        $duration = $interval->days;

        $accessories = App\Models\DashboardOrderAccessory::where('order_id', $order->dashboard_order_id)->get();
    @endphp
    <tbody>
    <tr @class([
        'assigned' => $order->order_status == 'Assigned',
        'due-date' => ($order->order_status == 'Assigned') && (date('Y-m-d H:i:s', strtotime($order->end_date)) < date('Y-m-d H:i:s')),
        'completed' => $order->order_status == 'Completed',
        'pending' => $order->order_status == 'Pending',
        'processing' => $order->order_status == 'Processing',
    ])>
        <td>
            <div class="tooltip">
                <a href="/orders/{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}}</a>
                <span class="tooltiptext" style="width: 250px">
                    Start/End Time: {{date('H:i',strtotime($order->start_date))}}<br>
                    Bikes: {{$order->number_of_bikes}}<br>
                    Address: {{$order->address}}<br>
                    Accessories:
                    @if (count($accessories) > 0)
                        @foreach ($accessories as $acc)
                            {{$acc->quantity}} {{$acc->name}} <br>
                        @endforeach
                    @else
                        None
                    @endif
                </span>
            </div>
        </td>
        <td>{{$order->first_name}} {{$order->last_name}}</td>
        <td>
            <div class="status-selector">
                <form method="POST" action="orders/status/{{$order->dashboard_order_id}}">
                    @csrf
                    @method('PUT')
                    <select onchange="this.form.submit()" name="order_status" id="order_status" @class([
                        'slct-btn' => true,
                        'slct-pending' => $order->order_status == 'Pending',
                        'slct-processing' => $order->order_status == 'Processing',
                        'slct-assigned' => $order->order_status == 'Assigned',
                        'slct-completed' => $order->order_status == 'Completed'])>
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
        <td nowrap>
            {{-- If order assigned display bike info, else display icon --}}
            @if (count($order->history) <= 0)
                <a href="/orders/{{$order->dashboard_order_id}}/assign">
                    <i @class([
                        'fa-solid fa-bicycle bikes-assigned' => $order->bikes_assigned == 1,
                        'fa-solid fa-bicycle' => $order->bikes_assigned != 1])>
                    </i>
                </a>               
            @else
                @foreach ($order->history as $entry)
                    @php
                        $bike = App\Models\Bike::where('id', $entry->bike_id)->first();
                    @endphp
                    {{ $bike->rack }} | {{ $bike->code }} <br>
                @endforeach 
            @endif
        </td>
        <td>{{$order->mobile}}</td>
        <td>{{$order->accommodation}}</td>
        <td nowrap>{{$frmtStartDate}}</td>
        <td nowrap>{{$duration}}</td>
        <td nowrap>{{$frmtEndDate}}</td>
        <td>{{$order->number_of_bikes}}</td>
        <td>{{$order->amount_paid}}</td>
        

        <td>{{$order->pickup_location}}</td>
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
        {{-- TEMP SMS SENDING BUTTONS --}}
        <td>
            @if ($order->start_date_sms != 1)
                <form method="GET" action="/orders/pre-pickup/{{$order->dashboard_order_id}}">
                    @csrf
                    <button onclick="this.form.submit()"><i class="fa-solid fa-envelope"></i></button>
                </form>
            @else
                <span style="color: green">Sms sent</span>
            @endif
        </td>

        <td>
            @if ($order->end_date_sms != 1)
                <form method="GET" action="/orders/reminder/{{$order->dashboard_order_id}}">
                    @csrf
                    <button onclick="this.form.submit()"><i class="fa-solid fa-envelope"></i></button>
                </form>
            @else
                <span style="color: green">Sms sent</span>
            @endif
        </td>
        
    </tr>
    </tbody>
@endforeach
</table>



<h1 style="margin-top: 100px">Future Bookings</h1>
<table id="late-orders-table" class="orders-table">
    <thead>
    <tr>
        {{-- sortTable(n, isStatus, isLink, isDate, isNum) --}}
        <th onclick="sortTable(0,0,1,0,1)">Order ID</th>
        <th onclick="sortTable(1,0,0,0,0)">Name</th>
        <th onclick="sortTable(2,1,0,0,0)">Status</th>
        <th onclick="sortTable(3,0,0,0,1)" style="padding-right: 10px" nowrap >Rack | Code</th>
        <th onclick="sortTable(4,0,0,0,1)">Phone number</th>
        <th onclick="sortTable(5,0,0,0,0)">Acc</th>
        <th onclick="sortTable(6,0,0,1,0)">Start Date</th>
        <th onclick="sortTable(7,0,0,0,1)">Duration</th>
        <th onclick="sortTable(8,0,0,1,0)">End Date</th>
        <th onclick="sortTable(9,0,0,0,1)"># Bikes</th>
        <th onclick="sortTable(10,0,0,0,1)">$</th>
        <th onclick="sortTable(11,0,0,0,0)">Pickup</th>
        <th></th>
        <th></th>
        <th>Pre-Pickup SMS</th>
        <th>Reminder SMS</th>
    </tr>
    </thead>
    @foreach ($ordersWeekFromNow as $order)
    @php
        $frmtStartDate = date('d-m-Y (g A)',strtotime($order->start_date));
        $frmtEndDate = date('d-m-Y (g A)',strtotime($order->end_date));

        $date1 = new DateTime($order->start_date);
        $date2 = new DateTime($order->end_date);
        $interval = $date1->diff($date2);
        $duration = $interval->days;

        $accessories = App\Models\DashboardOrderAccessory::where('order_id', $order->dashboard_order_id)->get();
    @endphp
    <tbody>
    <tr @class([
        'assigned' => $order->order_status == 'Assigned',
        'due-date' => ($order->order_status == 'Assigned') && (date('Y-m-d H:i:s', strtotime($order->end_date)) < date('Y-m-d H:i:s')),
        'completed' => $order->order_status == 'Completed',
        'pending' => $order->order_status == 'Pending',
        'processing' => $order->order_status == 'Processing',
    ])>
        <td>
            <div class="tooltip">
                <a href="/orders/{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}}</a>
                <span class="tooltiptext" style="width: 250px">
                    Start/End Time: {{date('H:i',strtotime($order->start_date))}}<br>
                    Bikes: {{$order->number_of_bikes}}<br>
                    Address: {{$order->address}}<br>
                    Accessories:
                    @if (count($accessories) > 0)
                        @foreach ($accessories as $acc)
                            {{$acc->quantity}} {{$acc->name}} <br>
                        @endforeach
                    @else
                        None
                    @endif
                </span>
            </div>
        </td>
        <td>{{$order->first_name}} {{$order->last_name}}</td>
        <td>
            <div class="status-selector">
                <form method="POST" action="orders/status/{{$order->dashboard_order_id}}">
                    @csrf
                    @method('PUT')
                    <select onchange="this.form.submit()" name="order_status" id="order_status" @class([
                        'slct-btn' => true,
                        'slct-pending' => $order->order_status == 'Pending',
                        'slct-processing' => $order->order_status == 'Processing',
                        'slct-assigned' => $order->order_status == 'Assigned',
                        'slct-completed' => $order->order_status == 'Completed'])>
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
        <td nowrap>
            {{-- If order assigned display bike info, else display icon --}}
            @if (count($order->history) <= 0)
                <a href="/orders/{{$order->dashboard_order_id}}/assign">
                    <i @class([
                        'fa-solid fa-bicycle bikes-assigned' => $order->bikes_assigned == 1,
                        'fa-solid fa-bicycle' => $order->bikes_assigned != 1])>
                    </i>
                </a>               
            @else
                @foreach ($order->history as $entry)
                    @php
                        $bike = App\Models\Bike::where('id', $entry->bike_id)->first();
                    @endphp
                    {{ $bike->rack }} | {{ $bike->code }} <br>
                @endforeach 
            @endif
        </td>
        <td>{{$order->mobile}}</td>
        <td>{{$order->accommodation}}</td>
        <td nowrap>{{$frmtStartDate}}</td>
        <td nowrap>{{$duration}}</td>
        <td nowrap>{{$frmtEndDate}}</td>
        <td>{{$order->number_of_bikes}}</td>
        <td>{{$order->amount_paid}}</td>
        

        <td>{{$order->pickup_location}}</td>
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
        {{-- TEMP SMS SENDING BUTTONS --}}
        <td>
            @if ($order->start_date_sms != 1)
                <form method="GET" action="/orders/pre-pickup/{{$order->dashboard_order_id}}">
                    @csrf
                    <button onclick="this.form.submit()"><i class="fa-solid fa-envelope"></i></button>
                </form>
            @else
                <span style="color: green">Sms sent</span>
            @endif
        </td>

        <td>
            @if ($order->end_date_sms != 1)
                <form method="GET" action="/orders/reminder/{{$order->dashboard_order_id}}">
                    @csrf
                    <button onclick="this.form.submit()"><i class="fa-solid fa-envelope"></i></button>
                </form>
            @else
                <span style="color: green">Sms sent</span>
            @endif
        </td>
        
    </tr>
    </tbody>
@endforeach
</table>
@endsection

