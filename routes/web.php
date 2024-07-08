<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableAvailabilityController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\RoleController;
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

// Routes for Google and Facebook Login
Route::get('/auth/{provider}', [ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);

Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/user/roles', [RoleController::class, 'index'])->name('index');
    Route::post('/user/roles/store', [RoleController::class, 'store'])->name('store');
});

// Route::post('/booking/{id}', [TableAvailabilityController::class, 'update'])->middleware(['auth', 'verified', 'role:admin']);
// This is called by a HTML form, which doesn't really have a PUT method -> make it urself
// Updates: Turns out @method('PUT') in the form can also do the trick
Route::resource('/booking', TableAvailabilityController::class)->middleware(['auth', 'verified', 'role:admin']);
// here you cant really name the route 'booking' since its a 'resource' route -> many types of request with varied parameter amount, check the below profile auth middleware.

Route::resource('/table', TableController::class)->middleware(['auth', 'verified']);

Route::resource('/user', UserController::class)->middleware(['auth', 'verified']);

Route::get('/filter/{date}/{timeslot}', [TableAvailabilityController::class, 'filter'])->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/payment/{id}', [PaymentController::class, 'momopay']);
Route::get('/payment/{id}/success', [PaymentController::class, 'pay_succ']);

require __DIR__.'/auth.php';
