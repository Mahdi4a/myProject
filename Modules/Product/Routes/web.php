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
use Modules\Product\Http\Controllers\Client\ProductController;

Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('attribute/value', [ProductController::class, 'getValue']);
    Route::post('value/details', [ProductController::class, 'getValueDetails']);
    Route::get('single_product/{product:slug}', [ProductController::class, 'single'])->name('single.product');
});
