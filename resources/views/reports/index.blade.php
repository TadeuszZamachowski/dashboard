@extends('layout')
@section('content')
<h1 style="padding-bottom: 20px">Reports</h1>
<a class="btn" href="/reports/salesByLocation"><i class="fa-solid fa-location-dot" style="color:white"></i>Sales By Location</a>
<a class="btn" href="/reports/graph"><i class="fas fa-chart-bar" style="color:white"></i>Assigned Bikes Graph</a>
<a class="btn" href="/reports/bikesByType"><i class="fa-solid fa-bicycle" style="color:white"></i>Bike number by type and colour</a>
   
@endsection