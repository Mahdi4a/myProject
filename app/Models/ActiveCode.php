<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActiveCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'code',
        'user_id',
        'phone',
        'expired_at',
    ];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeVerifyCode($query,$code,$user,$phone)
    {
        return (bool)$user->activeCode()->whereCode($code)->where('expired_at' ,">",now())->wherePhone($phone)->first();
    }

    public function scopeGenerateCode($query,$user,$phone)
    {
//        if($code = $this->getAliveCodeForUser($user,$phone)){
//            $code = $code->code;
//        }else {
//
//        }
        $user->activeCode()->delete();
        do {
            $code = random_int(100000, 999999);
        } while ($this->checkCodeIsUnique($user, $code,$phone));

        $user->activeCode()->create([
            'code' => $code,
            'phone' => $phone,
            'expired_at' => now()->addMinutes(10),
        ]);
        return $code;
    }

    private function checkCodeIsUnique($user, int $code,$phone)
    {
        return (bool)$user->activeCode()->whereCode($code)->wherePhone($phone)->first();
    }

    private function getAliveCodeForUser($user,$phone)
    {
        return $user->activeCode()->where('expired_at','>',now())->wherePhone($phone)->first();
    }
}
