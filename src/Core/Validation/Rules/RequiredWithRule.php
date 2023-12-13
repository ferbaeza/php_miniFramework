<?php

namespace Src\Core\Validation\Rules;

use Src\Core\Validation\Interfaces\ValidationRule;

class RequiredWithRule implements ValidationRule
{
    public function __construct(
        public readonly string $field
    ) {
    }

    /**@inheritDoc */
    public function message(string $field): string
    {
        return "The field is required when {$field} is present.";
    }

    /**@inheritDoc */
    public function isValid(string $value, array $data = []): bool
    {
        if (isset($this->field) && !empty($this->field)) {
            return isset($data[$value]) && !empty($data[$value]);
        }
        return true;
    }
}
