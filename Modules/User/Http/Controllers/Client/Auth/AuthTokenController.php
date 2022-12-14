<?php

namespace Modules\User\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\Entities\ActiveCode;
use Modules\User\Entities\User;
use Modules\User\Http\Requests\Profile\verifyPhoneNumberRequest;

class AuthTokenController extends Controller
{
    //

    public function getToken(request $request)
    {
        if (!$request->session()->has('auth')) {
            return redirect(route('login'));
        }
        $request->session()->reFlash();
        return view('auth.token');
    }

    public function postToken(verifyPhoneNumberRequest $request)
    {
        if (!$request->session()->has('auth')) {
            return redirect(route('login'));
        }

        $user = User::query()->findOrFail($request->session()->get('auth.user_id'));
        $request->session()->reFlash();
        if(!ActiveCode::verifyCode($request->code, $user,$user->phone_number)){
            alert()->error('کد وارد شده اشتباه است');
            return redirect(route('get.token'));
        }

        if(auth()->loginUsingId($user->id,$request->session()->get('auth.remember'))){
            $user->activeCode()->delete();
            return redirect('/');
        }
        return redirect(route('login'));

    }
}
