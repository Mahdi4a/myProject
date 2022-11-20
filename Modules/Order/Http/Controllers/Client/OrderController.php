<?php

namespace Modules\Order\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Modules\Payment\Http\Repositories\PaymentRepository;

class OrderController extends Controller
{
    public function getOrders(Request $request)
    {
        $orders = $request->user()->orders()->latest()->paginate();
        return view("user::profile.orders", compact('orders'));
    }

    public function getOrderDetail(Request $request)
    {
        $order = $request->user()->orders()->where('id', $request->data)->firstOrFail();
        return view("user::profile.order-details", compact('order'));
    }

    public function orderPayment(Request $request, Order $order)
    {
        return (new PaymentRepository())->orderPayment($request, $order);
    }
}
