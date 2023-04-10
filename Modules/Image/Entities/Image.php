<?php

namespace Modules\Image\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $hidden = [
        'taggable_id'
    ];


    protected $fillable = [
        'address',
    ];

}
