<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Permission\Http\Controllers\Admin\PermissionController;
use Modules\Permission\Http\Controllers\Admin\RoleController;

Route::resource('permissions', PermissionController::class);
Route::resource('roles', RoleController::class);
