<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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


// Page Routes
Route::controller( UserController::class )->group( function () {
    Route::get( '/login', 'LoginPage' )->name( 'login' );
    Route::get( '/registration', 'RegistrationPage' )->name( 'registration' );
    Route::get( '/sendOtp', 'SendOtpPage' )->name( 'sendOtp' );
    Route::get( '/verifyOtp', 'VerifyOTPPage' );
    Route::get( '/resetPassword', 'ResetPasswordPage' )->name( 'resetPassword' );
} );


Route::controller( DashboardController::class )->group( function () {
    Route::get( '/', 'DashboardPage' )->middleware( [ 'jwt.verify' ] );
    Route::get( '/dashboard', 'DashboardPage' )->middleware( [ 'jwt.verify' ] )->name( 'dashboard' );
} );
