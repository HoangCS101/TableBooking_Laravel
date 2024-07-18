<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BookingController;

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