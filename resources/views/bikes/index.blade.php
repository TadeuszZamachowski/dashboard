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
        <th onclick="sortTable(0,0)">Rack</th>
        <th onclick="sortTable(0,0)">Color</th>
        <th onclick="sortTable(0,0)">Type</th>
        <th onclick="sortTable(0,0)">Code</th>
        <th onclick="sortTable(0,0)">Location</th>
        <th onclick="sortTable(0,0)">Status</th>
        <th onclick="sortTable(0,0)">Order ID</th>
        <th onclick="sortTable(0,0)">Name</th>
        <th></th>
        <th></th>
        <th></th>
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
<div class="container">
    <a class="btn" href="/bikes/add">Add Bike</a>
</div>
@endsection
