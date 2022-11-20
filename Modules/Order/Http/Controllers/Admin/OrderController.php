<?php

namespace Modules\Order\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Order\Entities\Order;
use Modules\Order\Http\Order\OrderRepository;
use Modules\Order\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{
    public function __construct(protected OrderRepository $orderRepository)
    {
        $this->middleware('can:show-orders')->only(['index']);
        $this->middleware('can:create-order')->only(['create', 'store']);
        $this->middleware('can:edit-order')->only(['edit', 'update']);
        $this->middleware('can:delete-order')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = $this->orderRepository->ordersWithPaginate();
        return view('order::admin.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function payment(Order $order)
    {
        $payments = $this->orderRepository->orderPaymentsWithPage($order);
        return view('order::admin.payment', compact('payments', 'order'));
    }

    /**
     * Display the specified resource.
     *
     * @param Order $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Order $order)
    {
        $products = $this->orderRepository->orderDetailsWithPage($order);
        return view('order::admin.details', compact('products', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('order::admin.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderUpdateRequest $request, Order $order)
    {
        $order->update([
            'status' => $request->status,
            'tracking_serial' => $request->tracking_serial
        ]);

        return redirect(route('admin.orders.index') . '?type=' . $order->status);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        alert()->success('سفارش مورد نظر با موفقیت حذف شد');
        return back();
    }
}
