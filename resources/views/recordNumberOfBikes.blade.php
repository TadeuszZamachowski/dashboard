@php
    $response = App\Http\Controllers\BikeController::recordNumberOfBikes();
@endphp

{{$response}}