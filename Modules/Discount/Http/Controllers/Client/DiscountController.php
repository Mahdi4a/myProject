<?php

namespace Modules\Discount\Http\Controllers\Client;

use App\Services\Cart\Cart;
use Illuminate\Routing\Controller;
use Modules\Discount\Entities\Discount;
use Modules\Discount\Http\Requests\CheckDiscountRequest;

class DiscountController extends Controller
{
    public function check(CheckDiscountRequest $request)
    {
        if (!auth()->check()) {
            return back()->withInput($request->all())->withErrors([
                'discount' => 'برای اعمال کد تخفیف لطفا اپتدا وارد سایت شوید'
            ]);
        }

        $discount = Discount::query()->whereCode($request->discount)->first();
        if ($discount->expired_at < now()) {
            return back()->withInput($request->all())->withErrors([
                'discount' => 'مهلت استفاده از این کد تخفیف به پایان رسیده است'
            ]);
        }

        if ($discount->users()->count() && !in_array(auth()->user()->id, $discount->users()->pluck('id')->toArray(), true)) {
            return back()->withInput($request->all())->withErrors([
                'discount' => 'شما قادر به استفاده از این کد تخفیف نمیباشید'
            ]);
        }

        $cart = Cart::instance();
        $cart->addDiscount($discount->code);
        return back();
    }

    public function destroy()
    {
        Cart::instance()->addDiscount(null);
        return back();

    }
}
