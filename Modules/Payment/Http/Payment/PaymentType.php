<?php

namespace Modules\Payment\Http\Payment;

abstract class PaymentType
{
    public static function create($product_type)
    {
        return match ($product_type) {
            'nextPay' => new NextPay(),
            'crypto' => new Crypto(),
            'paypal' => new Paypal(),
            'payPing' => new PayPing(),
            default => (object)[],
        };
    }
}
