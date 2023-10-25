@extends('layout')

@section('content')
<style>
    .calendar {
        margin-top: 20px;
    }
</style>
<a class ="btn" href="\schedule\update">Update</a>
@if (count($nullOrders) > 0)
    <span style="color: red">Unassigned orders - {{count($nullOrders)}}</span>
@else
    <span style="color: green">Schedule up to date!</span>
@endif
<div class="calendar">
    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=2&bgcolor=%23ffffff&ctz=Australia%2FSydney&showTitle=0&showNav=1&showPrint=0&showTabs=1&showCalendars=1&showTz=0&mode=MONTH&src=YWQwNTgyYjc4NzllMmUwOTlmMDE0OWU2N2I1YzA1ZTgwMTY1MmE0NWNiNTNmNjAwODUwYmMxOGQ0ZjA0ZGI1ZEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%23E67C73" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
</div>
@endsection