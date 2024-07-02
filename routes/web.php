<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableAvailabilityController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
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
// Route::get('/booking', function () {
//     return view('booking');
// })->middleware(['auth', 'verified'])->name('booking');

Route::get('/', function () {
    return view('welcome');
});

Route::post('/booking/{id}', [TableAvailabilityController::class, 'update'])->middleware(['auth', 'verified']);
Route::resource('/booking', TableAvailabilityController::class)->middleware(['auth', 'verified']);
// here you cant really name the route 'booking' since its a 'resource' route -> many types of request with varied parameter amount, check the below profile auth middleware.

Route::resource('/table', TableController::class)->middleware(['auth', 'verified']);

Route::resource('/user', UserController::class)->middleware(['auth', 'verified']);

Route::get('/filter/{date}/{timeslot}', [TableAvailabilityController::class, 'filter'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
