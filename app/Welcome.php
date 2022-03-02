<?php

namespace App;

class Welcome
{
    /**
     * @var AuthenticatesUser
     */
    public $auth;

    public function __construct(AuthenticatesUser $auth)
    {
        $this->auth = $auth;
    }
}
