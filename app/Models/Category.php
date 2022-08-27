<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'category_id',
        'user_id',
        'user_id_updated',
        'part_id',
        'part_type',
        'status',
    ];

    public function product()
    {
        return $this->HasMany(Product::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(__CLASS__,'category_id','id');
    }

    public function childCategory()
    {
        return $this->HasMany(__CLASS__);
    }

    public function markStatusAsActive()
    {
        return $this->forceFill([
            'status' => 1,
        ])->save();
    }
}
