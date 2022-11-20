<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Client\Auth\AuthTokenController;
use Modules\User\Http\Controllers\Client\Auth\GoogleAuthController;
use Modules\User\Http\Controllers\Profile\IndexController;
use Modules\User\Http\Controllers\Profile\TokenAuthController;
use Modules\User\Http\Controllers\Profile\TwoFactorController;

Auth::routes(['verify' => true]);
Route::prefix('auth')->group(function () {
    Route::get('google', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('google/callback', [GoogleAuthController::class, 'callback']);
    Route::get('token', [AuthTokenController::class, 'getToken'])->name('get.token');
    Route::post('token', [AuthTokenController::class, 'postToken']);
});
Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('profile');
    Route::get('twoFactor', [TwoFactorController::class, 'manageTwoFactor'])->name('two.factor.auth');
    Route::post('twoFactor', [TwoFactorController::class, 'postManageTwoFactor']);
    Route::get('verify/phone', [TokenAuthController::class, 'getVerifyPhoneNumber'])->name('get.verify.phone');
    Route::post('verify/phone', [TokenAuthController::class, 'verifyPhoneNumber'])->name('verify.phone');
});
