<?php

namespace Modules\Order\Http\Order;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\Order\Entities\Order;

//use Your Model

/**
 * Class OrderRepository.
 */
class OrderRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Order::class;
    }

    public function ordersWithPaginate()
    {
        $orders = $this->model->query();
        $orders->where('status', request('type'));
        if ($keyword = request('search')) {
            $orders->whereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%");
            })
                ->orWhere('tracking_serial', $keyword)
                ->orWhere('finalPrice', $keyword)
                ->orWhere('id', $keyword);
        }
        return $orders->latest()->paginate(20);
    }

    public function orderPaymentsWithPage($order)
    {
        $payments = $order->payments();
        if ($keyword = request('search')) {
            $payments->where('id', $keyword);
        }
        return $payments->latest()->paginate(20);
    }

    public function orderDetailsWithPage($order)
    {
        $payments = $order->orderItems();
        if ($keyword = request('search')) {
            $payments->where('id', $keyword)
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWherePivot('price', $keyword)
                ->orWherePivot('quantity', $keyword);
        }
        return $payments->latest()->paginate(20);
    }
}
