<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TableAvailabilityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
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
// Route::get('/booking', function () {
//     return view('booking');
// })->middleware(['auth', 'verified'])->name('booking');

Route::get('/', function () {
    return view('welcome');
});

// Routes for Google and Facebook Login (Socialite)
Route::get('/auth/{provider}', [ProviderController::class, 'redirect']);
Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);

// Roles and Permissions (Spatie)
Route::middleware(['auth', 'role:admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::prefix('/roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/', [RoleController::class, 'store'])->name('roles.store');
        Route::put('/{id}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/{id}/permissions', [RoleController::class, 'list'])->name('roles.list');
        Route::get('/{id}/{perid}', [RoleController::class, 'toggle'])->name('roles.toggle'); // I know, GET is not cool here, will change in the future
    });
    Route::prefix('/permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions.index');
        Route::post('/', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('/{id}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/{id}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
    });
    Route::get('/stat',[StatisticController::class, 'index']);
    Route::get('/stat/subscription',[StatisticController::class, 'subscription']);
    Route::get('/stat/popularity',[StatisticController::class, 'tablePopularity']);
});

// Route::post('/booking/{id}', [TableAvailabilityController::class, 'update'])->middleware(['auth', 'verified', 'role:admin']);
// This is called by a HTML form, which doesn't really have a PUT method -> make it urself
// Updates: Turns out putting @method('PUT') in the form can also pull the trick

Route::middleware(['auth', 'verified', 'permission:manage bookings'])->group(function () {
    // Booking basics
    Route::resource('/booking', TableAvailabilityController::class); // here you cant really name the route 'booking' since its a 'resource' route -> many types of request with varied parameter amount, check the below profile auth middleware.
    Route::get('/booking/filter/{date}/{timeslot}', [TableAvailabilityController::class, 'filter']);
    Route::get('/booking/preview/{id}', [TableAvailabilityController::class, 'previewTable']);

    // Payment (Momo + VNPAY)
    Route::post('/payment/momo/{id}/{total}', [PaymentController::class, 'momopay']);
    Route::get('/payment/momo/{id}/callback', [PaymentController::class, 'momopay_succ']);
    Route::post('/payment/vnpay/{id}/{total}', [PaymentController::class, 'vnpay']);
    Route::get('/payment/vnpay/{id}/callback', [PaymentController::class, 'vnpay_succ']);
});

// Manage Timeslots, Tables and Users
Route::get('/timeslot/list', [TimeslotController::class, 'list'])->middleware(['auth', 'verified']);
Route::resource('/timeslot', TimeslotController::class)->middleware(['auth', 'verified', 'permission:manage timeslot']);
Route::resource('/table', TableController::class)->middleware(['auth', 'verified', 'permission:manage tables']);
Route::get('/user/{id}/roles', [UserController::class, 'list'])->middleware(['auth', 'verified', 'permission:manage users']);
Route::get('/user/{id}/{roleid}', [UserController::class, 'toggle'])->middleware(['auth', 'verified', 'permission:manage users']); // I know, GET is not cool here, will change in the future
Route::resource('/user', UserController::class)->middleware(['auth', 'verified', 'permission:manage users']);

// Authentication (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
});

// Chatbox (Pusher)
Route::get('/chat/online', [ChatController::class, 'checkOnline']);
Route::get('/chat/{chatId}', [ChatController::class, 'viewChat']);
Route::post ('/chat/{chatId}', [ChatController::class, 'sendMessage']);

Route::get('/token/create', function (Request $request) {
    $token = $request->user()->createToken('apiToken', ['*'], now()->addWeek());
 
    return response()->json(['token' => $token->plainTextToken]);
})->middleware(['auth', 'verified', 'permission:generate token']);

require __DIR__ . '/auth.php';
