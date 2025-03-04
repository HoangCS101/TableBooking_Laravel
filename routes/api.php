<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\TimeslotController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// }); // So this is the same as the get user below.

Route::post('/login', [AuthController::class, 'login']);

Route::apiResource('booking', BookingController::class)->except([
    'create', 'show', 'edit'
])->middleware(['auth:sanctum', 'check.permission:manage bookings']);
// check.permission is made to deal with api permissions specifically, check \App\Http\Kernel for more info

Route::apiResource('timeslot', TimeslotController::class)->only([
    'index'
])->middleware(['auth:sanctum', 'check.permission:see timeslots']);

Route::middleware('auth.pat')->group(function () {
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    Route::delete('/user', [UserController::class, 'delete']);
    Route::get('/user', [UserController::class, 'get']);
});