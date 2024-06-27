<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableAvailabilityController;
use App\Http\Controllers\TableController;
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

Route::get('/', function () {
    return redirect('/booking');
});
Route::resource('/booking', TableAvailabilityController::class);
Route::resource('/table', TableController::class);
Route::get('/filter/{date}/{timeslot}', [TableAvailabilityController::class, 'filter']);
