<?php

namespace Src\Core\Auth;

use Src\Core\Auth\AuthModel;
use Src\Core\Auth\Interfaces\AuthInterface;

class Authenticator implements AuthInterface
{
    public function login(AuthModel $auth)
    {
        session()->set('_auth', $auth);
    }
    public function logout(AuthModel $auth)
    {
        session()->remove('_auth');
    }
    public function isAuth(AuthModel $auth): bool
    {
        return false;
    }
    public function resolve()
    {
        session()->get('_auth');
    }

}
