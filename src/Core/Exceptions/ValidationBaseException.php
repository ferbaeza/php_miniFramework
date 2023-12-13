<?php

namespace Src\Core\Exceptions;

use Src\Core\Exceptions\BaseException;
use Src\Core\Validation\Exceptions\ValidationException;

class ValidationBaseException extends BaseException
{
    protected static $messages = [
        ValidationException::class => "Config key not found"
    ];
}
