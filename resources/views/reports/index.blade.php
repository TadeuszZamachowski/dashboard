@extends('layout')
@section('content')
<h1 style="padding-bottom: 20px">Reports</h1>
<a class="btn" href="/reports/salesByLocation"><i class="fa-solid fa-location-dot" style="color:white"></i>Sales By Location</a>
<a class="btn" href="/reports/graph"><i class="fas fa-chart-bar" style="color:white"></i>Assigned Bikes Graph</a>
<a class="btn" href="/reports/bikesStatistics"><i class="fa-solid fa-bicycle" style="color:white"></i>Bike stats</a>
<a class="btn" href="/orders/archive"><i class="fa-solid fa-book" style="color:white"></i>Order Archive</a>
<a class="btn" href="/reports/bikeArchive"><i class="fa-solid fa-book" style="color:white"></i>Bike Archive</a>
<a class="btn" href="/reports/statistics"><i class="fa-solid fa-chart-column" style="color:white"></i>Statistics</a>


   
@endsection