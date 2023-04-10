<?php

namespace Modules\User\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Profile\twoFactorRequest;
use Modules\User\Http\Repositories\ProfileRepository;

class TwoFactorController extends Controller
{

    public function __construct(protected ProfileRepository $profileRepository)
    {
    }

    public function manageTwoFactor()
    {
        return view('user::profile.twoFactorAuth');
    }

    public function postManageTwoFactor(twoFactorRequest $request)
    {
        return $this->profileRepository->updateTwoFactor($request);
    }
}
