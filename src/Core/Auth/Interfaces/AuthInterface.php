<?php

namespace Src\Core\Auth\Interfaces;

use Src\Core\Auth\AuthModel;

interface AuthInterface
{
    public function login(AuthModel $auth);
    public function logout(AuthModel $auth);
    public function isAuth(AuthModel $auth): bool;
    public function resolve();
}
