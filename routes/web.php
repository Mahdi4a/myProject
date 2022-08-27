<?php

use App\Http\Controllers\Auth\AuthTokenController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Client\Profile\IndexController;
use App\Http\Controllers\Client\Profile\TokenAuthController;
use App\Http\Controllers\Client\Profile\TwoFactorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Process\Process;

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

Route::get('/bash', function () {
//    dd(public_path('bash_script\bash.sh'));
    $proccess = new Process([public_path('bash_script/bash.sh')]);
//    dd($proccess->run());
//    dd($proccess->getOutput());
    ($proccess->run(function ($type, $buffer) {
        if (Process::ERR === $type) {
            echo 'ERR > ' . $buffer;
        } else {
            echo 'OUT > ' . $buffer;
        }
    }));
    $proccess->getOutput();
});

Route::get('/', function () {
    if(\Illuminate\Support\Facades\Gate::allows('edit-user')){
        return view('welcome');
    }
    return 'no';
});

Auth::routes(['verify'=>true]);

Route::get('auth/google',[GoogleAuthController::class ,'redirect'])->name('auth.google');
Route::get('auth/google/callback',[GoogleAuthController::class ,'callback']);
Route::get('auth/token',[AuthTokenController::class ,'getToken'])->name('get.token');
Route::post('auth/token',[AuthTokenController::class ,'postToken']);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::prefix('profile')->middleware(['auth'])->group(function(){
    Route::get('/', [IndexController::class, 'index'])->name('profile');
    Route::get('twoFactor', [TwoFactorController::class, 'manageTwoFactor'])->name('two.factor.auth');
    Route::post('twoFactor', [TwoFactorController::class, 'postManageTwoFactor']);
    Route::get('verify/phone', [TokenAuthController::class, 'getVerifyPhoneNumber'])->name('get.verify.phone');
    Route::post('verify/phone', [TokenAuthController::class, 'verifyPhoneNumber'])->name('verify.phone');

});

