<?php

use App\Http\Controllers\AutomationController;
use App\Http\Controllers\BikeController;
use App\Http\Controllers\BikesCheckController;
use App\Http\Controllers\BikesDashboardOrderController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardIncidentController;
use App\Http\Controllers\DashboardOrder;
use App\Http\Controllers\DashboardOrderController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group
|
*/

//---------------------> LOGIN

//show login form
Route::get('/login',  [LoginController::class, 'login'])->name('login');

//verify login
Route::post('/login', [LoginController::class, 'doLogin'])->name('login');


//---------------------> HOME
Route::get('/dashboard', [DashboardOrderController::class,'home'])->middleware('auth');



//---------------------> ORDERS
//All orders
Route::get('/', [DashboardOrderController::class, 'index'])->middleware('auth');

//Show create form
Route::get('/orders/add', [DashboardOrderController::class, 'create'])->middleware('auth');

//Store order data
Route::post('/orders', [DashboardOrderController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/orders/{order}/edit', [DashboardOrderController::class, 'edit'])->middleware('auth');

//Update order
Route::put('/orders/{order}', [DashboardOrderController::class, 'update'])->middleware('auth');

//Update order status from index
Route::put('/orders/status/{order}', [DashboardOrderController::class, 'updateStatusOnly'])->middleware('auth');

//Delete order
Route::delete('/orders/{order}', [DashboardOrderController::class, 'destroy'])->middleware('auth');

//Show archived orders
Route::get('/orders/archive', [DashboardOrderController::class, 'archive'])->middleware('auth');

//Show single order
Route::get('/orders/{order}', [DashboardOrderController::class, 'show'])->middleware('auth');

//Show single archived order
Route::get('/orders/archive/{order}', [DashboardOrderController::class, 'showArchive'])->middleware('auth');




//---------------------> BIKES 

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

//Store bike check
Route::post('/bikes/check/{bike}', [BikesCheckController::class, 'store'])->middleware('auth');

//Show bound to rack form
Route::get('/bikes/boundToRack/{rack}', [BikeController::class, 'boundToRack'])->middleware('auth');

//Store connection
Route::post('/bikes/boundToRack/{rack}', [BikeController::class, 'boundToRackStore'])->middleware('auth');

//Free rack
Route::get('/bikes/freeRack/{rack}', [BikeController::class, 'freeRack'])->middleware('auth');


//---------------------> SCHEDULE
Route::get('/schedule',[DashboardOrderController::class, 'showSchedule'])->middleware('auth');

Route::get('/schedule/update',[DashboardOrderController::class, 'updateSchedule'])->middleware('auth');


//---------------------> HISTORY
//Show Assign bike to order form
Route::get('/orders/{order}/assign', [BikesDashboardOrderController::class, 'show'])->middleware('auth');

//Store data
Route::post('/assign/{order}', [BikesDashboardOrderController::class, 'store'])->middleware('auth');

//Show Assign order to bike form
Route::get('/bikes/{bike}/assign', [BikesDashboardOrderController::class, 'showBikeSide'])->middleware('auth');

//Store data
Route::post('/bikes/assign/{bike}', [BikesDashboardOrderController::class, 'storeBikeSide'])->middleware('auth');

//Delete from history
Route::delete('/bikes/assign/{bike}', [BikesDashboardOrderController::class, 'destroy'])->middleware('auth');

//Show history of orders
Route::get('/history', [BikesDashboardOrderController::class, 'index'])->middleware('auth');


//---------------------> SETTINGS
//show settings
Route::get('/settings', [SettingsController::class, 'index'])->middleware('auth');

//show codes
Route::get('/settings/codes', [SettingsController::class, 'codes'])->middleware('auth');

//add codes
Route::post('/settings/codes', [SettingsController::class, 'codesStore'])->middleware('auth');

//delete codes
Route::delete('/settings/codes/{code}', [SettingsController::class, 'codesDestroy'])->middleware('auth');



//show accessories
Route::get('/settings/accessories', [SettingsController::class, 'accessories'])->middleware('auth');

//add accessories
Route::post('/settings/accessories', [SettingsController::class, 'accessoriesStore'])->middleware('auth');

//delete accessories
Route::delete('/settings/accessories/{accessory}', [SettingsController::class, 'accessoriesDestroy'])->middleware('auth');



//show locations
Route::get('/settings/locations', [SettingsController::class, 'locations'])->middleware('auth');

//add locations
Route::post('/settings/locations', [SettingsController::class, 'locationsStore'])->middleware('auth');

//delete locations
Route::delete('/settings/locations/{location}', [SettingsController::class, 'locationsDestroy'])->middleware('auth');



//show colors
Route::get('/settings/colors', [SettingsController::class, 'colors'])->middleware('auth');

//add colors
Route::post('/settings/colors', [SettingsController::class, 'colorsStore'])->middleware('auth');

//delete colors
Route::delete('/settings/colors/{color}', [SettingsController::class, 'colorsDestroy'])->middleware('auth');




//show racks
Route::get('/settings/racks', [SettingsController::class, 'racks'])->middleware('auth');

//add racks
Route::post('/settings/racks', [SettingsController::class, 'racksStore'])->middleware('auth');

//delete racks
Route::delete('/settings/racks/{rack}', [SettingsController::class, 'racksDestroy'])->middleware('auth');



//show accommodations
Route::get('/settings/accommodations', [SettingsController::class, 'accommodations'])->middleware('auth');

//add accommodations
Route::post('/settings/accommodations', [SettingsController::class, 'accommodationsStore'])->middleware('auth');

//delete accommodations
Route::delete('/settings/accommodations/{accommodation}', [SettingsController::class, 'accommodationsDestroy'])->middleware('auth');



//show automation 
Route::get('/settings/automation', [SettingsController::class, 'automation'])->middleware('auth');

//edit automation
Route::post('settings/automation', [SettingsController::class, 'automationEdit'])->middleware('auth');



//---------------------> INCIDENTS
Route::get('/incidents', [DashboardIncidentController::class, 'index'])->middleware('auth');

//show add incidents form
Route::get('/incidents/add', [DashboardIncidentController::class, 'create'])->middleware('auth');

//store incident
Route::post('/incidents', [DashboardIncidentController::class, 'store'])->middleware('auth');

//Show edit form
Route::get('/incidents/{incident}/edit', [DashboardIncidentController::class, 'edit'])->middleware('auth');

//Update incident
Route::put('/incidents/{incident}', [DashboardIncidentController::class, 'update'])->middleware('auth');

//Delete incident
Route::delete('/incidents/{incident}', [DashboardIncidentController::class, 'destroy'])->middleware('auth');

//---------------------> INVENTORY
Route::get('/inventory', [BikeController::class, 'inventory'])->middleware('auth');


//---------------------> REPORTS
Route::get('/reports', [ReportsController::class,'index'])->middleware('auth');

Route::get('/reports/salesByLocation', [ReportsController::class, 'salesByLocation'])->middleware('auth');

Route::get('/reports/salesByLocation/result', [ReportsController::class,'process'])->middleware('auth');

Route::get('/reports/bikesByType', [ReportsController::class, 'bikesByType'])->middleware('auth');

Route::get('/reports/bikesByType/result', [ReportsController::class,'bikeTypeProcess'])->middleware('auth');

Route::get('/reports/graph', [ReportsController::class, 'graph'])->middleware('auth');

Route::get('/reports/bikeArchive', [BikeController::class, 'bikeArchive'])->middleware('auth');

//Map bikes
Route::get('mapBikes', [BikeController::class, 'mapBikes'])->middleware('auth');

//Messaging
Route::get('/messages', [SmsController::class, 'index'])->middleware('auth');
Route::post('/messages/send', [SmsController::class, 'send'])->middleware('auth');


//---------------------> Save assigned bikes number cron
Route::get('/recordNumberOfBikes', [BikeController::class, 'recordNumberOfBikes']);


//---------------------> TEMP SMS
Route::get('/orders/pre-pickup/{order}', [DashboardOrderController::class, 'prePickup'])->middleware('auth');

Route::get('/orders/reminder/{order}', [DashboardOrderController::class, 'reminder'])->middleware('auth');

Route::get('/orders/promo/{order}', [DashboardOrderController::class, 'promo'])->middleware('auth');


//Pre pickup and reminder SMS cron
Route::get('/smsScheduled', [SmsController::class, 'schedule']);

Route::get('/sendMailTest', [MailController::class, 'sendEmail']);

Route::get('/autoAssign', [AutomationController::class, 'assign']);