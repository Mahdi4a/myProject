<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);//->using(ProductAttributeValue::class)->withPivot(['product_id']);
    }
}
