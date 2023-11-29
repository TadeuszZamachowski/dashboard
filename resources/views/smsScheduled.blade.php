@php
    $response1 = App\Http\Controllers\SmsController::checkOneHourBeforeStartDate();
    $response2 = App\Http\Controllers\SmsController::checkOneHourBeforeEndDate();
@endphp

{{$response1}} <br>
{{$response2}}