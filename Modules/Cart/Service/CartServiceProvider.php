<?php

namespace App\Services\Cart;

use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('cart', function () {
            return new CartService();
        });
    }
}
