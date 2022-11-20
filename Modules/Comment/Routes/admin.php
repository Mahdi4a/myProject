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
use Modules\Comment\Http\Controllers\Admin\CommentController;

Route::get('/comment/unapproved', [CommentController::class, 'unapproved'])->name('comment.unapproved');
Route::resource('comment', CommentController::class, ['names' => ['index' => 'comment.approved']])->only('show', 'index', 'approved', 'unapproved', 'update', 'destroy');
