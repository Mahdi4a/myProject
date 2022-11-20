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
use Modules\Order\Http\Controllers\Client\OrderController;

Route::prefix('profile')->middleware(['auth'])->group(function () {
    Route::get('orders/detail', [OrderController::class, 'getOrderDetail']);
    Route::get('orders', [OrderController::class, 'getOrders'])->name('get.orders');
    Route::get('order/{order}/payment', [OrderController::class, 'orderPayment'])->name('order.payment');
});
