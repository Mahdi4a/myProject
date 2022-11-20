<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Main\Http\Controllers\Admin\MainController;

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

Route::get('/', function () {
    auth()->loginUsingId(1);
    return view('main::admin.index');
})->name('index');


Route::get('modules', [MainController::class, 'index'])->name('modules.index');
Route::patch('modules/{module}/enable', [MainController::class, 'enable'])->name('modules.enable');
Route::patch('modules/{module}/disable', [MainController::class, 'disable'])->name('modules.disable');
