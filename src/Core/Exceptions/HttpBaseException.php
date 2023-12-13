<?php

namespace Src\Core\Exceptions;

use Src\Core\Exceptions\BaseException;
use Src\Core\Http\Exceptions\HttpNotFoundException;

class HttpBaseException extends BaseException
{
    protected static $messages = [
        HttpNotFoundException::class => "Config key not found"
    ];
}
