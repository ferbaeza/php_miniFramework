<?php

namespace Src\Core\Validation\Exceptions;

use Src\Core\Exceptions\ValidationBaseException;

class ValidationException extends ValidationBaseException
{
    public function __construct(
        public array $errors
    ) {
    }

    public function errores()
    {
        return $this->errors;
    }
}
