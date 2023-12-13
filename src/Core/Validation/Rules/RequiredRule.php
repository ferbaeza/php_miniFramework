<?php

namespace Src\Core\Validation\Rules;

use Src\Core\Validation\Interfaces\ValidationRule;

class RequiredRule implements ValidationRule
{
    /**@inheritDoc */
    public function message(string $field): string
    {
        return "The field {$field} is required.";
    }

    /**@inheritDoc */
    public function isValid(string $value, array $data = []): bool
    {
        return isset($data[$value]) && !empty($data[$value]);
    }
}
