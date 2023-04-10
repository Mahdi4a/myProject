<?php

namespace Modules\Payment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['resourceNumber', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
