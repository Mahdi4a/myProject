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

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\Client\PaymentController;

Route::prefix('payment')->group(function () {
    Route::post('', [PaymentController::class, 'payment'])->name('cart.payment');
});
Route::get('{method}/callback', [PaymentController::class, 'paymentCallback'])->name('bank.callback');

