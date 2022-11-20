<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Attribute\Entities\Attribute;
use Modules\Category\Entities\Category;
use Modules\Comment\Entities\Comment;
use Modules\Image\Entities\Image;
use Modules\Main\Entities\ModelHelper;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\Order_product;

class Product extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;

    protected $fillable = [
        'title',
        'name',
        'slug',
        'description',
        'status',
        'user_id_updated',
        'view_count',
        'user_id',
        'seo_description',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->using(ProductAttributeValue::class)->withPivot(['value_id']);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageAble')->orderByDesc('id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'comment')->where('parent_id', 0)->where('approved', 1);
    }


    /**
     * @return void
     */
    public function addRelationToProduct(): void
    {
        $this->firstAttribute = $this?->attributes()?->first();
        $this->firstValue = $this?->firstAttribute?->pivot?->value;

        if ($this->firstValue) {
            $this->firstValue->priceWithDiscount = $this->firstValue->price - (($this->firstValue->price * $this->firstValue->discount) / 100);
        }
    }


    public function orderItems()
    {
        return $this->belongsToMany(Order::class)->using(Order_product::class)->withPivot(['value_id', 'attribute_id']);
    }
}
