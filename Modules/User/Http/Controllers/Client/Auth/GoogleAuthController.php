<?php

namespace Modules\User\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Modules\User\Http\Repositories\GoogleAuthRepository;

class GoogleAuthController extends Controller
{
    use TwoFactorAuthenticate;

    public function __construct(private GoogleAuthRepository $googleRepository)
    {
    }

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $check = $this->googleRepository->checkUserExists($googleUser);
            if($this->loggedIn($request,$check)) {
                return $this->loggedIn($request, $check);
            }
            return redirect()->route($check ? 'home': 'login');
        }catch(\Exception $e){
            alert()->error('ورود با گوگل موفق نبود','خطا')->showCancelButton('بستن', 'red');
            return redirect()->route('login')->with('message',$e->getMessage());
        }
    }
}
