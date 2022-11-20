<?php

namespace Modules\User\Http\Controllers\Client\Auth;

use App\Notifications\UserLoggedInNotification;
use Modules\User\Entities\ActiveCode;

trait TwoFactorAuthenticate
{
    public function loggedIn($request, $user)
    {

        if ($user->hasTwoFactorAuthEnabled()) {
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
