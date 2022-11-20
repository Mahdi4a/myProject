<?php

namespace Modules\Payment\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Cart\Service\Cart;
use Modules\Payment\Http\Repositories\PaymentRepository;

class PaymentController extends Controller
{
    public function __construct(protected PaymentRepository $paymentRepository)
    {
    }

    public function payment(Request $request)
    {
        $cart = Cart::instance();
        $cartItems = $cart->all();
        if ($cartItems->count()) {
            $order = $this->paymentRepository->makeOrder($request, $cartItems);
            return $this->paymentRepository->goToBank($request, $order);
        }
        return back();
    }

    public function paymentCallback(Request $request, $method)
    {
        return $payment = $this->paymentRepository->collback($request, $method);

        DB::beginTransaction();
        try {
            if ($payment['response']->code === -1 && !is_null($payment['transaction'] && $payment['transaction']->pay_status === '0')) {
                $payment['transaction']->update([
                    'pay_status' => '1',
                ]);
                $wallet = $payment['transaction']->User->wallet;

                if ($payment['transaction']->type === 'deposit') {
                    $wallet->update([
                        'real_credit' => $wallet->real_credit + $request->amount,
                        'amount' => $wallet->amount + $request->amount
                    ]);
                }
                if (!is_null($payment['transaction']->post_id)) {
                    $this->storeBuyPostUser(collect(['post_id' => $payment['transaction']->post_id, 'user_id' => $payment['transaction']->user_id,]));
                    $wallet->updatePrice($request->amount);
                    $wallet->updateAmount();
                }
            }
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            $data = $exception;
            $message = trans('messages.Wallet.transfer.rollback');
            return $this->__response(false, [
                'message' => $message,
                'data' => $data,
            ], 400);
        }
        return view('payment.callback', [
            'payment' => $payment,
            'token' => $payment['response']->order_id,
            'message' => $payment['message'],
            'title' => 'callback title',
        ]);
    }
}
