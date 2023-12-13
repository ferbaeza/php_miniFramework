<?php

namespace Src\Core\Validation\Rules;

use Src\Core\Validation\Interfaces\ValidationRule;

class MaximunRule implements ValidationRule
{
    protected $param;

    public function __construct($param)
    {
        $this->param = $param;
    }

    /**@inheritDoc */
    public function message(string $field): string
    {
        return "The field {$field} is bigger than required.";
    }

    /**@inheritDoc */
    public function isValid(string $value, array $data = []): bool
    {
        if(is_string($data[$value])) {
            return strlen($data[$value]) <= $this->param;
        }
        if (is_numeric($data[$value])) {
            return $data[$value] <= $this->param;
        }
        return false;
    }
}
