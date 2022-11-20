<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Product\Entities\Product;

class Order_product extends Pivot
{

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }

    public function value()
    {
        return $this->belongsTo(AttributeValue::class, 'value_id', 'id');
    }
}
