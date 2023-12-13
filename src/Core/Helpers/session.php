<?php

use Src\Core\Session\Session;

function session(): Session
{
    return app()->session;
}

function oldSession()
{
    return session()->get('_old');
}
