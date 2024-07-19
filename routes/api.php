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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::get('/hello', function () {
//     return "Hello World!";
// });
// Route::post('/reverse-me', function (Request $request) {
//     $reversed = strrev($request->input('reverse_this'));
//     return $reversed;
// });

Route::apiResource('booking', BookingController::class)->except([
    'create', 'show', 'edit'
]);

Route::apiResource('timeslot', TimeslotController::class)->only([
    'index'
]);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.pat')->group(function () {
    Route::put('/user/profile', [UserController::class, 'updateProfile']);
    Route::put('/user/password', [UserController::class, 'updatePassword']);
    Route::delete('/user', [UserController::class, 'delete']);
    Route::get('/user', [UserController::class, 'test']);
});