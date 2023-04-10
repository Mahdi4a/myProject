<?php

namespace Modules\Payment\Http\Payment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NextPay extends PaymentType
{

    public function goForPay($request, $order)
    {
        $CallbackUrl = route('bank.callback', ['method' => 'nextPay']);
        $api_key = config('services.bank_token.nextPay');
        $response = Http::asForm()->post('https://nextpay.org/nx/gateway/token', [
            'api_key' => $api_key,
            'amount' => $order->price,
            'order_id' => $request->token,
            'callback_uri' => $CallbackUrl,
        ]);
        $response = json_decode($response->body(), false);
        $link = 'https://nextpay.org/nx/gateway/payment/' . $response->trans_id;
        if ($response->code === -1) {
            return redirect($link);
            return [
                'message' => $this->callbackAlert($response->code),
                'link' => $link,
                'amount' => $response->amount,
            ];
        }
        return [
            'message' => $this->callbackAlert($response->code),
            'link' => null,
            'amount' => $response->amount ?? 0,
        ];
    }

    public function callback(Request $request)
    {
        $amount = $request['amount'];
        $trans_id = $request['trans_id'];
        $token = $request['order_id'];
        $status = $request['np_status'];

        $api_key = config('services.bank_token.nextPay');
        $response = Http::asForm()->post('https://nextpay.org/nx/gateway/verify', [
            'api_key' => $api_key,
            'amount' => $amount,
            'trans_id' => $trans_id,
        ]);
        $response = json_decode($response->body(), false);
        return $this->callbackAlert($response->code);

    }

    public function callbackAlert($errCode)
    {
        $ErrTxt = array(
            '0' => 'پرداخت موفق',
            '-1' => 'تراکنش در وضعیت آماده برای ارسال به بانک است',
            '-2' => 'تراکنش به بانک ارسال شده ودرحال پرداخت توسط خریداراست',
            '-3' => 'هنوز پاسخی در خصوص نتیجه تراکنش از بانک دریافت نشده است',
            '-4' => 'تراکنش توسط پرداخت کننده کنسل شده است',
            '-20' => 'کلید مجوزدهی (api_key)ارسال نشده است(یا مقدار پارامتر مورد نظر خالی است)',
            '-21' => 'شماره تراکنش  (trans_id )ارسال نشده یا خالی ارسال شده است',
            '-22' => 'مبلغ  (amount )ارسال نشده است',
            '-23' => 'مسیر بازگشت  (callback_uri )ارسال نشده است',
            '-24' => 'مقدار عددی مبلغ صحیح نیست',
            '-25' => 'شماره تراکنش (trans_id) دوباره ارسال شده یا قابل پرداخت نیست',
            '-26' => 'شمارهتراکنش (trans_id )ارسال نشده است',
            '-27' => 'تراکنش لغو شد',
            '-30' => 'مبلغ کمتر از 100تومان است',
            '-32' => 'ساختار مسیر بازگشت صحیح نیست',
            '-33' => 'کلید مجوزدهی (api_key)صحیح نیست',
            '-34' => 'شماره ترا کنش (trans_id) صحیح نیست',
            '-35' => 'نوع کلید مجوزدهی (مانند لینک، مستقیم و ...) صحیح نیست',
            '-36' => 'شماره سفارش (order_id )ارسال نشده یا بیش از 32کاراکتر است',
            '-37' => 'تراکنش موجود نیست',
            '-38' => 'شماره توکن یافت نشد',
            '-39' => 'کلید مجوزدهی یافت نشد',
            '-40' => 'کلید مجوزدهی مسدود شده است',
            '-41' => 'پارامتر های ارسالی از طرف بانک صحیح نیست',
            '-42' => 'سیستم پرداخت در نکست پی دچار مشکل شده است',
            '-43' => 'درگاه پرداختی برای انجام روال بانکی یافت نشده است',
            '-44' => 'بانک عامل پاسخگو نبوده است',
            '-45' => 'سیستم پرداخت در نکست پی غیر فعال شده است',
            '-46' => 'درخواست ارسالی اشتباه است یا در نکست پی تعریف نشده است',
            '-48' => 'نرخ کمیسیون تعیین نشده است',
            '-49' => 'تراکنش یکبار انجام شده و دوباره قابل انجام نیست',
            '-50' => 'حساب کاربری یافت نشد',
            '-51' => 'کاربری در سیستم یافت نشد'
        );
        return $ErrTxt[$errCode];
    }

}
