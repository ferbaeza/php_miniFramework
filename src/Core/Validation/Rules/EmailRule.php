<?php

namespace Src\Core\Validation\Rules;

use Src\Core\Validation\Interfaces\ValidationRule;

class EmailRule implements ValidationRule
{
    /**@inheritDoc */
    public function message(string $field): string
    {
        return "The {$field} must be a valid email address.";
    }

    /**@inheritDoc */
    public function isValid(string $email, array $data = []): bool
    {
        return filter_var($data[$email], FILTER_VALIDATE_EMAIL);
    }
}
