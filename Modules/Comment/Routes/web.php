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
use Modules\Comment\Http\Controllers\Client\CommentController;

Route::middleware(['auth'])->group(function () {
    Route::post('store/comment', [CommentController::class, 'storeComments'])->name('store.comment');
});
