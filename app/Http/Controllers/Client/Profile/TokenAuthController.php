<?php

namespace App\Http\Controllers\Client\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Profile\verifyPhoneNumberRequest;
use App\Repositories\Client\Profile\ProfileRepository;
use Illuminate\Http\Request;

class TokenAuthController extends Controller
{

    public $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }


    public function verifyPhoneNumber(verifyPhoneNumberRequest $request)
    {
        return $this->profileRepository->verifyCode($request);
    }

    public function getVerifyPhoneNumber(Request $request)
    {
        if(!$request->session()->has('phone')){
            return redirect(route('two.factor.auth'));
        }
        $request->session()->reFlash();
        return view('profile.verifyPhoneNumber');
    }
}
