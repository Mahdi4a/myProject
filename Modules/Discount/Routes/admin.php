<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Discount\Http\Controllers\Admin\DiscountController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('discount', DiscountController::class);
