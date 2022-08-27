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


use App\Http\Controllers\Admin\Category\CategoryController;
use App\Http\Controllers\Admin\Permission\PermissionController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Role\RoleController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\Admin\Users\UserPermissionController;
use Illuminate\Support\Facades\Route;

Route::get('/',function(){
    auth()->loginUsingId(1);
    return view('admin.index');
})->name('index');


Route::resource('users',UserController::class);
Route::get("/users/{user}/permissions",[UserPermissionController::class , 'create'])->name('users.permissions');
Route::post('/users/{user}/permissions', [UserPermissionController::class , 'store'])->name('users.permissions.store');
Route::resource('permissions',PermissionController::class);
Route::resource('roles',RoleController::class);
Route::resource("product",ProductController::class);
Route::resource('category',CategoryController::class);
