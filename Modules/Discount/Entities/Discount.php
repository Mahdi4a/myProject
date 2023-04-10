<?php

namespace Modules\Discount\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\User\Entities\User;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'percent', 'expired_at'];

    protected static function newFactory()
    {
        return \Modules\Discount\Database\factories\DiscountFactory::new();
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function allUsers()
    {
        return $this->users->pluck('name', 'id')->toArray();
    }

    public function allProducts()
    {
        return $this->products->pluck('name', 'id')->toArray();
    }

    public function allCategories()
    {
        return $this->categories->pluck('name', 'id')->toArray();
    }
}
