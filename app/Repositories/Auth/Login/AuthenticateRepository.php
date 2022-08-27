<?php

namespace App\Repositories\Auth\Login;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class AuthenticateRepository.
 */
class AuthenticateRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        //return YourModel::class;
    }

    public function checkLogin($request, $user)
    {

    }

    public function getToken($request)
    {
        if (!$request->session()->has('auth')) {
            return redirect('/');
        }
        return view('auth.token');
    }
}
