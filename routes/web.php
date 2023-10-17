<?php

use App\Http\Controllers\BikeController;
use App\Http\Controllers\BikesDashboardOrderController;
use App\Http\Controllers\DashboardOrder;
use App\Http\Controllers\DashboardOrderController;
use App\Http\Controllers\LoginController;
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

//---------------------> LOGIN

//show login form
Route::get('/login',  [LoginController::class, 'login'])->name('login');

//verify login
Route::post('/login', [LoginController::class, 'doLogin'])->name('login');



//---------------------> ORDERS
//All orders
Route::get('/', [DashboardOrderController::class, 'index'])->middleware('auth');

//Show create form
Route::get('/orders/add', [DashboardOrderController::class, 'create'])->middleware('auth');

//Store order data
Route::post('/', [DashboardOrderController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/orders/{order}/edit', [DashboardOrderController::class, 'edit'])->middleware('auth');

//Update order
Route::put('/orders/{order}', [DashboardOrderController::class, 'update'])->middleware('auth');

//Delete order
Route::delete('/orders/{order}', [DashboardOrderController::class, 'destroy'])->middleware('auth');

//Show single order
Route::get('/orders/{order}', [DashboardOrderController::class, 'show'])->middleware('auth');




//----------------------> BIKES 

//All bikes
Route::get('/bikes', [BikeController::class, 'index'])->middleware('auth');

//Show create form
Route::get('/bikes/add', [BikeController::class, 'create'])->middleware('auth');

//Store bike data
Route::post('/bikes', [BikeController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/bikes/{bike}/edit', [BikeController::class, 'edit'])->middleware('auth');

//Update bike
Route::put('/bikes/{bike}', [BikeController::class, 'update'])->middleware('auth');

//Delete bike
Route::delete('/bikes/{bike}', [BikeController::class, 'destroy'])->middleware('auth');

//Show single bike
Route::get('/bikes/{bike}', [BikeController::class, 'show'])->middleware('auth');


//Schedule
Route::get('/schedule', function() {
    return view('schedule');
})->middleware('auth');

//Show Assign bike form
Route::get('/orders/{order}/assign', [BikesDashboardOrderController::class, 'show'])->middleware('auth');

//Store data
Route::post('/assign/{order}', [BikesDashboardOrderController::class, 'store'])->middleware('auth');

//Show history of orders
Route::get('/history', [BikesDashboardOrderController::class, 'index'])->middleware('auth');






//Learning and stuff
Route::get('/tests/{no}', function ($no) {
    //ddd($no); DUMP DIE DEBUG
    return response("Test number". $no);
})->where('no', '[0-9]+');

Route::get('/search', function (Request $request) {
    return($request->name . " ". $request->state);
});
