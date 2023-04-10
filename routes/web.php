<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
//
//Route::get('create/download/link',[DownloadController::class , 'createLink']);
//Route::get('download/{user}/link',[DownloadController::class , 'downloadLink'])->name('download.link');
//Route::get('/', function () {
//    return view('client.index');
//})->name('home');

Route::get('/home', [HomeController::class, 'index']);

//Route::middleware(['auth'])->group(function(){
//    Route::prefix('profile')->group(function(){
//        Route::get('/', [IndexController::class, 'index'])->name('profile');
//        Route::get('twoFactor', [TwoFactorController::class, 'manageTwoFactor'])->name('two.factor.auth');
//        Route::post('twoFactor', [TwoFactorController::class, 'postManageTwoFactor']);
//        Route::get('verify/phone', [TokenAuthController::class, 'getVerifyPhoneNumber'])->name('get.verify.phone');
//        Route::post('verify/phone', [TokenAuthController::class, 'verifyPhoneNumber'])->name('verify.phone');
//        Route::get('orders/detail', [OrderController::class, 'getOrderDetail']);
//        Route::get('orders', [OrderController::class, 'getOrders'])->name('get.orders');
//        Route::get('order/{order}/payment', [OrderController::class, 'orderPayment'])->name('order.payment');
//    });
//    Route::post('store/comment', [HomeController::class, 'storeComments'])->name('store.comment');
//    Route::post('payment',[PaymentController::class , 'payment'])->name('cart.payment');
//});

//Route::get('payPing/callback',[PaymentController::class, 'PaypingCallback'])->name('payPing.callback');
//Route::get('nextPay/callback',[PaymentController::class, 'PaypingCallback'])->name('nextPay.callback');
//Route::get('products',[ProductController::class, 'index']);
//Route::post('product/attribute/value',[ProductController::class, 'getValue']);
//Route::post('product/value/details',[ProductController::class, 'getValueDetails']);
//Route::get('single_product/{product:slug}',[ProductController::class, 'single'])->name('single.product');
//Route::post("cart/add/{product}",[CartController::class,'addToCart'])->name('cart.add');
//Route::get("cart",[CartController::class,'cart'])->name('cart.get');
//Route::delete("cart/{id}",[CartController::class,'cartDeleteItem'])->name('cart.item.destroy');
