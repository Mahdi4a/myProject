<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Modules\Main\Entities\ModelHelper;
use Modules\Product\Entities\Product;

class Category extends Model
{
    use HasFactory, SoftDeletes, ModelHelper;

    protected $fillable = [
        'title',
        'name',
        'slug',
        'description',
        'seo_description',
        'category_id',
        'user_id',
        'user_id_updated',
        'part_id',
        'part_type',
        'status',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }

    public function parentCategory()
    {
        return $this->belongsTo(__CLASS__, 'category_id', 'id');
    }

    public function childCategory()
    {
        return $this->HasMany(__CLASS__);
    }
}
