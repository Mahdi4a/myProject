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
use Modules\Cart\Http\Controllers\Client\CartController;

Route::prefix('cart')->group(function () {
    Route::post('add/{product}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/', [CartController::class, 'cart'])->name('cart.get');
    Route::delete('{id}', [CartController::class, 'cartDeleteItem'])->name('cart.item.destroy');
});
