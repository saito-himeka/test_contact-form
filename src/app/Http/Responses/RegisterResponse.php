<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * 登録後のリダイレクト先を /admin に設定
     */
    public function toResponse($request)
    {
        return redirect('/admin');
    }
}
