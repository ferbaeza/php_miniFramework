<?php

namespace Src\Core\Exceptions;

use Exception;

class BaseException extends Exception
{
    protected static $messages = [];

    public static function create(): static
    {
        /** @phpstan-ignore-next-line */
        return new static(static::$messages[static::class]);
    }
}
