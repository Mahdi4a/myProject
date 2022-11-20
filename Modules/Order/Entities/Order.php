<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Payment\Entities\Payment;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'status', 'price', 'finalPrice', 'orderShip', 'tax', 'toll', 'extra', 'description', 'tracking_serial'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(Product::class)->using(Order_product::class)->withPivot(['value_id', 'attribute_id', 'quantity', 'price']);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
