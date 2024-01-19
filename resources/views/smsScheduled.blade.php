@php
    $response1 = App\Http\Controllers\SmsController::checkOneHourBeforeStartDate();
    $response2 = App\Http\Controllers\SmsController::checkOneHourBeforeEndDate();
    $response3 = App\Http\Controllers\SmsController::checkPromo();
@endphp

{{$response1}} <br>
{{$response2}} <br>
{{$response3}}