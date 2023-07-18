<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::controller(UserController::class)->group(function () {
    Route::post( '/user-registration', 'UserRegistration' );
    Route::post( '/user-login', 'UserLogin');
    Route::post( '/send-otp', 'SendOTPCode' );
    Route::post( '/verify-otp', 'VerifyOTP');
    Route::post( '/reset-password', 'ResetPassword');
});