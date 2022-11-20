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
use Modules\Main\Http\Controllers\DownloadController;

Route::get('/', function () {
    return view('main::client.index');
})->name('home');

Route::get('create/download/link', [DownloadController::class, 'createLink']);
Route::get('download/{user}/link', [DownloadController::class, 'downloadLink'])->name('download.link');
