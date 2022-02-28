<?php

namespace App\Http\Controllers;

use App\AuthenticatesUser;
use App\Models\LoginToken;

class AuthController extends Controller
{
    /**
     * @var AuthenticatesUser
     */
    public $auth;

    public function __construct(AuthenticatesUser $auth)
    {
        $this->auth = $auth;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin()
    {
        $this->auth->invite();
        return 'sweet';
    }
    public function token(LoginToken $token)
    {
        $this->auth->login($token);
    }
}
