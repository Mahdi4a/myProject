<?php

namespace App\Http\Controllers\Client\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Profile\twoFactorRequest;
use App\Repositories\Client\Profile\ProfileRepository;
use Illuminate\Http\Request;

class TwoFactorController extends Controller
{
    public $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }
    public function manageTwoFactor()
    {
        return view('profile.twoFactorAuth');
    }

    public function postManageTwoFactor(twoFactorRequest $request)
    {
        return $this->profileRepository->updateTwoFactor($request);
    }
}
