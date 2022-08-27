<?php

namespace App\Http\Controllers\Auth;

use App\Models\ActiveCode;
use App\Notifications\ActiveCodeNotification;
use App\Notifications\UserLoggedInNotification;

trait TwoFactorAuthenticate
{
    public function loggedIn($request,$user)
    {

        if($user->hasTwoFactorAuthEnabled()){
            auth()->logout();

            $request->session()->flash('auth',[
                'user_id' => $user->id,
                'using_sms' => false,
                'remember' => $request->has('remember'),
            ]);
            if($user->two_factor_type === 'sms')
            {
                $code = ActiveCode::generateCode($user, $user->phone_number);
//                $user->notify(new ActiveCodeNotification($code,$user->phone_number));
                $request->session()->push('auth.using_sms',true);
            }
            return redirect(route('get.token'));
        }
        $user->notify(new UserLoggedInNotification());
        return false;
    }
}
