@extends('layout')

@section('content')

<div class="sorting-section">
    <div class="filter-selector">
        <form method="GET" action="/">
            <select name="filter" id="filter">
                <option selected="selected">{{$filter}}</option>
                @foreach ($categories as $item)
                    @if ($item == $filter || $item == 'Completed')
                        {{-- Don't display duplicates --}}
                    @else
                        <option value={{$item}}>  {{$item}} </option>
                    @endif
                @endforeach
                <option value="">None</option>
            </select>
            <button type="submit">Go</button>
        </form>
    </div>
    <div class="search-bar">
        <form method="GET" action="/">
            <input name="search" type="text" placeholder="Search.." value="{{$search}}">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>
    </div>
</div>

<table id="orders-table" class="orders-table">
    <thead>
    <tr>
        <th onclick="sortTable(0,0)">Order ID</th>
        <th onclick="sortTable(1,0)">Name</th>
        <th onclick="sortTable(2,0)">Phone number</th>
        <th onclick="sortTable(3,0)">Start Date</th>
        <th onclick="sortTable(4,0)">Duration</th>
        <th onclick="sortTable(5,0)">Amount</th>
        <th onclick="sortTable(6,0)">End Date</th>
        <th onclick="sortTable(7,1)">Status</th>
        <th onclick="sortTable(8,0)">Pickup</th>
        <th onclick="sortTable(9)" style="padding-right: 10px">Bikes</th>
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
        $frmtEndDate = date('d-m-Y',strtotime($order->end_date));

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
        <td><a href="/orders/{{$order->dashboard_order_id}}">{{$order->dashboard_order_id}}</a></td>
        <td>{{$order->first_name}} {{$order->last_name}}</td>
        <td>{{$order->mobile}}</td>
        <td nowrap>{{$frmtStartDate}}</td>
        <td nowrap>{{$duration}} days</td>
        <td>{{"$".$order->amount_paid}}</td>
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
        <td><a href="/orders/{{$order->dashboard_order_id}}/assign">
            <i @class([
                'fa-solid fa-bicycle bikes-assigned' => $order->bikes_assigned == 1,
                'fa-solid fa-bicycle' => $order->bikes_assigned != 1])></i></a>
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
<script>
    function sortTable(n, isStatus) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("orders-table");
      switching = true;
      // Set the sorting direction to ascending:
      dir = "asc";
      /* Make a loop that will continue until
      no switching has been done: */
      while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */
          if(isStatus == 1) {
            x = rows[i].getElementsByTagName("option")[0];
            console.log(x);
            y = rows[i + 1].getElementsByTagName("option")[0];
          } else {
            x = rows[i].getElementsByTagName("TD")[n];
            console.log(x);
            y = rows[i + 1].getElementsByTagName("TD")[n];
          }
          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          // Each time a switch is done, increase this count by 1:
          switchcount ++;
        } else {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }
</script>


<div class="pagination">
    {{ $orders->onEachSide(1)->links() }}
</div>
<a href="/orders/add" class="btn">Add Order</a>

@endsection

