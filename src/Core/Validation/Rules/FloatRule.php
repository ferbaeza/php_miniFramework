<?php

namespace Src\Core\Validation\Rules;

use Src\Core\Validation\Interfaces\ValidationRule;

class FloatRule implements ValidationRule
{
    /**@inheritDoc */
    public function message(string $field): string
    {
        return "The field {$field} is required.";
    }

    /**@inheritDoc */
    public function isValid(string $value, array $data = []): bool
    {
        $number = (str_contains($data[$value], '.', ) === true) ? floatval($data[$value]) : $data[$value];
        return is_float($number) && !empty($number);
    }
}
