<?php

namespace Modules\User\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Profile\verifyPhoneNumberRequest;
use Illuminate\Http\Request;
use Modules\User\Http\Repositories\ProfileRepository;

class TokenAuthController extends Controller
{
    public function __construct(protected ProfileRepository $profileRepository)
    {
    }


    public function verifyPhoneNumber(verifyPhoneNumberRequest $request)
    {
        return $this->profileRepository->verifyCode($request);
    }

    public function getVerifyPhoneNumber(Request $request)
    {
        if (!$request->session()->has('phone')) {
            return redirect(route('two.factor.auth'));
        }
        $request->session()->reFlash();
        return view('user::profile.verifyPhoneNumber');
    }
}
