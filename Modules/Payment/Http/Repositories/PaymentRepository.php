<?php

namespace Modules\Payment\Http\Repositories;

use Exception;
use Illuminate\Support\Str;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Cart\Service\Cart;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Payment\Http\Payment\PaymentType;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as BankPayment;

//use Your Model

/**
 * Class PaymentRepository.
 */
class PaymentRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Payment::class;
    }

    /**
     * @throws Exception
     */
    public function makeOrder($request, $cartItems)
    {
        $price = $cartItems->sum(function ($item) {
            return !$item['discount_percent'] == 0 ?
                $item['price'] * $item['quantity'] :
                ($item['price'] - ($item['price'] * $item['discount_percent'])) * $item['quantity'];
        });
        $order = $request->user()->orders()->create([
            'price' => $price,
            'finalPrice' => $price,
        ]);
        $array = [];
        $cartItems->mapWithKeys(function ($item) use (&$array, $order) {
            if (is_null($item)) return true;
            $array[$item['product']->id] =
                [
                    'quantity' => $item['quantity'],
                    'value_id' => $item['attribute_value'],
                    'attribute_id' => $item['attribute'],
                    'price' => $item['price'],
                ];
            $order->orderItems()->attach($array);
            return $order;
        });

//        Cart::flush();

        $token = $this->makeToken();
        $request->request->add(['token' => $token]);
        $this->makePayment($order, $token);
        return $order;
    }

    /**
     * @return string
     */
    public function makeToken(): string
    {
        $token = Str::random(10);
        $i = Payment::max('id');
        return $token . '_' . ++$i;
    }

    /**
     * @param $order
     * @param string $token
     * @return void
     */
    public function makePayment($order, string $token): void
    {
        $order->payments()->create([
            'resourceNumber' => $token,
        ]);
    }

    public function goToBank($request, $order)
    {
        $invoice = (new Invoice)->amount($order->price);
//dd($invoice,$request->all());
//        return PaymentType::create($request->type)->goForPay($request, $order);
        // You can specify callbackUrl
//        dd(route('bank.callback',['method' => $request->type]),config('services.bank_token.nextPay'));
        return BankPayment::callbackUrl(route('bank.callback', ['method' => $request->type]))
            ->config('merchantId', config('services.bank_token.nextPay'))
            ->via(strtolower($request->type))
            ->purchase(
                $invoice,
                static function ($driver, $transactionId) use ($order) {
                    $order->update(['tracking_serial' => $transactionId]);
                    // We can store $transactionId in database.
                }
            )->pay()->render();
    }

    public function storePayment($request)
    {
        Payment::query()->create([
            'user_id' => $request->user->id,
            'amount' => $request->amount,
            'token' => $request->token,
            'payment_status_id' => $request->status,
        ]);

    }

    public function collback($request, $type)
    {
//        dd($request->all(),$type);
        $order = Order::query()->select(['tracking_serial', 'price', 'user_id'])->where('tracking_serial', $request->trans_id)->first();
        // You need to verify the payment to ensure the invoice has been paid successfully.
        // We use transaction id to verify payments
        // It is a good practice to add invoice amount as well.
        try {
            $receipt = BankPayment::via(strtolower($type))
                ->transactionId($order?->tracking_serial)
                ->config('merchantId', config('services.bank_token.nextPay'))
                ->amount($order?->price)
                ->verify();

            // You can show payment referenceId to the user.
            return $receipt->getReferenceId();

        } catch (InvalidPaymentException $exception) {
            /**
             * when payment is not verified, it will throw an exception.
             * We can catch the exception to handle invalid payments.
             * getMessage method, returns a suitable message that can be used in user interface.
             **/
            return $exception->getMessage();
        }
        //return PaymentType::create($type)->callback($request);
    }

    public function orderPayment($request, $order)
    {
        $token = $this->makeToken();
        $this->makePayment($order, $token);
        $request->request->add(['token' => $token]);
        $request->token = $token;
        $request->amount = $order->finalPrice;
        return PaymentType::create('nextPay')->goForPay($request, $order);
    }

}
