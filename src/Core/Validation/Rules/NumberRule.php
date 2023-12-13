<?php

namespace Src\Core\Validation\Rules;

use Src\Core\Validation\Interfaces\ValidationRule;

class NumberRule implements ValidationRule
{
    /**@inheritDoc */
    public function message(string $field): string
    {
        return "The field {$field} is required.";
    }

    /**@inheritDoc */
    public function isValid(string $value, array $data = []): bool
    {
        return is_numeric($data[$value]) && !empty($data[$value]);
    }
}
