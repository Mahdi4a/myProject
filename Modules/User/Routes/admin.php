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
use Modules\User\Http\Controllers\Admin\UserController;
use Modules\User\Http\Controllers\Admin\UserPermissionController;

Route::resource('users', UserController::class);

Route::get('/users/{user}/permissions', [UserPermissionController::class, 'create'])->name('users.permissions');

Route::post('/users/{user}/permissions', [UserPermissionController::class, 'store'])->name('users.permissions.store');
