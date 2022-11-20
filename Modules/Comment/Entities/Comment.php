<?php

namespace Modules\Comment\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\User\Entities\User;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'comment',
        'approved',
        'comment_id',
        'comment_type',
        'user_id',
        'parent_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function childComments()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id');
    }


    public function childCommentsApproved()
    {
        return $this->hasMany(__CLASS__, 'parent_id', 'id')->where('approved', 1);
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}
