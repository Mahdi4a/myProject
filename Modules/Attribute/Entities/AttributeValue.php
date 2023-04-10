<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Product\Entities\ProductAttributeValue;

class AttributeValue extends Model
{
    use HasFactory;

    protected $table = 'attribute_values';
    protected $fillable = ['value', 'price', 'discount', 'inventory'];


    public function attribute()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_values', 'attribute_id', 'attribute_id')->using(ProductAttributeValue::class)->withPivot(['product_id']);
    }
}
