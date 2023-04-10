<?php

namespace Modules\User\Http\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Modules\User\Entities\ActiveCode;
use Modules\User\Entities\User;

//use Your Model

/**
 * Class ProfileRepository.
 */
class ProfileRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function updateTwoFactor($request)
    {
        if ($request->type === 'sms') {
            if($this->verifyPhoneNumber($request)) return $this->verifyPhoneNumber($request);
        }
        $request->user()->update([
            'two_factor_type' => $request->type,
        ]);
        return back();
    }

    public function verifyPhoneNumber($request)
    {
        if (is_null($request->user()->phone_verified_at) || $request->user()->phone_number !== $request->phone) {
            $code = ActiveCode::generateCode($request->user(), $request->phone);
            $request->session()->flash('phone', $request->phone);
//            $request->user()->notify(new ActiveCodeNotification($code,$request->phone));

            return redirect(route('get.verify.phone'));
        }
        return false;
    }

    public function verifyCode($request)
    {
        if (!$request->session()->has('phone')) {
            return redirect(route('two.factor.auth'));
        }

        if (ActiveCode::verifyCode($request->code, $request->user(),$request->session()->get('phone'))) {
            $request->user()->activeCode()->delete();
            $request->user()->update([
                'phone_number' => $request->session()->get('phone'),
                'two_factor_type' => 'sms',
                'phone_verified_at' => now(),
            ]);
            alert()->success("شماره تلفن و احراز هویت دو مرحله ای شما تایید شد!","عملیات موفقیت آمیز بود");
        }else{
            alert()->error("شماره تلفن و احراز هویت دو مرحله ای شما تایید نشد!","عملیات موفق نبود");
        }
        return redirect(route('two.factor.auth'));


    }
}
