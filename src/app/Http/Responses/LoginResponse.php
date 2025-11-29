<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * ログイン後のリダイレクト先を /admin に設定
     */
    public function toResponse($request)
    {
        return redirect('/admin');
    }
}
