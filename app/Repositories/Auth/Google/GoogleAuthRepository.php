<?php

namespace App\Repositories\Auth\Google;

use App\Models\User;
use Illuminate\Support\Str;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

/**
 * Class GoogleAuthRepository.
 */
class GoogleAuthRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function checkUserExists($googleUser)
    {
        $user = $this->model->query()->where('email', $googleUser->email)->first();
        $user ??= $this->createUserFromGoogle($googleUser);
        return $this->loginWithId($user);
    }

    public function loginWithId($user)
    {
        return auth()->loginUsingId($user->id);
    }

    public function createUserFromGoogle($googleUser)
    {
        $user = $this->model->query()->create([
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'password' => (Str::random(16)),
            'two_factor_type' => "off",
        ]);
        if(!$user->hasVerifiedEmail()){
            $user->markEmailAsVerified();
        }
        return $user;
    }

}
