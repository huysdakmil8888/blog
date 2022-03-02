<?php

namespace App;

use App\Models\LoginToken;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Mail;

class AuthenticatesUser
{
    use ValidatesRequests;

    /**
     * @var Request
     */
    public $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function invite()
    {
        $this->validateRequest()
            ->createToken()
            ->send();
    }

    protected function validateRequest()
    {
        $this->validate($this->request,[
            'email'=>'required|email|exists:users'
        ]);
        return $this;
    }

    private function createToken()
    {
        $user=User::byEmail($this->request->email);
        return LoginToken::generateFor($user);
    }

    public function login(LoginToken $token)
    {
        Auth::login($token->user);
//        $token->delete();
       return view('welcome');

    }

}
