@extends('layout')

@section('content')
<style>
    .calendar {
        margin-top: 20px;
    }
</style>
<a class ="btn" href="\schedule\update">Update</a>
<div class="calendar">
    <iframe src="https://calendar.google.com/calendar/embed?height=600&wkst=2&bgcolor=%23616161&ctz=Australia%2FSydney&showTitle=1&showNav=0&showDate=1&showPrint=0&showTabs=1&showCalendars=1&mode=WEEK&src=YWQwNTgyYjc4NzllMmUwOTlmMDE0OWU2N2I1YzA1ZTgwMTY1MmE0NWNiNTNmNjAwODUwYmMxOGQ0ZjA0ZGI1ZEBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%23E67C73" style="border:solid 2px #ffc4c4" width="1180" height="600" frameborder="0" scrolling="no"></iframe>
</div>
@endsection