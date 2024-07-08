<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TableAvailabilityController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
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
    Route::prefix('/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/{id}/permissions', [RoleController::class, 'list'])->name('roles.list');
        Route::get('/{id}/{perid}', [RoleController::class, 'toggle'])->name('roles.toggle'); // I know GET is not cool here, will change in the future
    });
    Route::prefix('/permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });
});

// Route::post('/booking/{id}', [TableAvailabilityController::class, 'update'])->middleware(['auth', 'verified', 'role:admin']);
// This is called by a HTML form, which doesn't really have a PUT method -> make it urself
// Updates: Turns out @method('PUT') in the form can also do the trick

Route::resource('/booking', TableAvailabilityController::class)->middleware(['auth', 'verified', 'permission:see bookings']);
// here you cant really name the route 'booking' since its a 'resource' route -> many types of request with varied parameter amount, check the below profile auth middleware.

Route::resource('/table', TableController::class)->middleware(['auth', 'verified', 'permission:edit tables']);

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
