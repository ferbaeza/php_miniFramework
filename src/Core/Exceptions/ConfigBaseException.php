<?php

namespace Src\Core\Exceptions;

use Src\Core\Exceptions\BaseException;
use Src\Core\Config\Exceptions\ConfigNotFoundException;

class ConfigBaseException extends BaseException
{
    protected static $messages = [
        ConfigNotFoundException::class => "Config key not found"
    ];
}
