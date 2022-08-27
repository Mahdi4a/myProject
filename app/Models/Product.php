<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category_id',
        'description',
        'price',
        'discount',
        'inventory',
        'status',
        'user_id_updated',
        'view_count',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function markStatusAsActive()
    {
        return $this->forceFill([
            'status' => 1,
        ])->save();
    }
}
