<?php

use App\Http\Controllers\BikeController;
use App\Http\Controllers\DashboardOrder;
use App\Http\Controllers\DashboardOrderController;
use App\Models\Postmeta;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//---------------------> ORDERS
//All orders
Route::get('/', [DashboardOrderController::class, 'index']);

//Show create form
Route::get('/orders/add', [DashboardOrderController::class, 'create']);

//Store order data
Route::post('/', [DashboardOrderController::class, 'store']);

//Show edit form
Route::get('/orders/{order}/edit', [DashboardOrderController::class, 'edit']);

//Update order
Route::put('/orders/{order}', [DashboardOrderController::class, 'update']);

//Delete order
Route::delete('/orders/{order}', [DashboardOrderController::class, 'destroy']);

//Show single order
Route::get('/orders/{order}', [DashboardOrderController::class, 'show']);




//----------------------> BIKES

//All bikes
Route::get('/bikes', [BikeController::class, 'index']);

//Show create form
Route::get('/bikes/add', [BikeController::class, 'create']);

//Store bike data
Route::post('/bikes', [BikeController::class, 'store']);

//Show edit form
Route::get('/bikes/{bike}/edit', [BikeController::class, 'edit']);

//Update bike
Route::put('/bikes/{bike}', [BikeController::class, 'update']);

//Delete bike
Route::delete('/bikes/{bike}', [BikeController::class, 'destroy']);

//Show single bike
Route::get('/bikes/{bike}', [BikeController::class, 'show']);

Route::get('/schedule', function() {
    return view('schedule');
});








//Learning and stuff
Route::get('/tests/{no}', function ($no) {
    //ddd($no); DUMP DIE DEBUG
    return response("Test number". $no);
})->where('no', '[0-9]+');

Route::get('/search', function (Request $request) {
    return($request->name . " ". $request->state);
});
