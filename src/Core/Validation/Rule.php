<?php

namespace Src\Core\Validation;

use Src\Core\Validation\Rules\EmailRule;
use Src\Core\Validation\Rules\NumberRule;
use Src\Core\Validation\Rules\MaximunRule;
use Src\Core\Validation\Rules\MinimunRule;
use Src\Core\Validation\Rules\RequiredRule;
use Src\Core\Validation\Rules\RequiredWithRule;
use Src\Core\Validation\Interfaces\ValidationRule;
use Src\Core\Validation\Rules\FloatRule;
use Src\Core\Validation\Rules\IntegerRule;
use Src\Core\Validation\Rules\StringRule;

class Rule
{
    private static array $rules = [];
    private static array $classRules = [
        'email' => EmailRule::class,
        'float' => FloatRule::class,
        'integer' => IntegerRule::class,
        'maximun' => MaximunRule::class,
        'minimun' => MinimunRule::class,
        'number' => NumberRule::class,
        'required' => RequiredRule::class,
        'requiredWith' => RequiredWithRule::class,
        'string' => StringRule::class,
    ];

    public static function loadRules(): array
    {
        foreach (self::$classRules as $name => $rule) {
            self::$rules[$name] = $rule;
        }
        return self::$rules;
    }

    public static function email(): ValidationRule
    {
        return new EmailRule();
    }

    public static function required(): ValidationRule
    {
        return new RequiredRule();
    }

    public static function requiredWith($field): ValidationRule
    {
        return new RequiredWithRule($field);
    }

    public static function maximun($param): ValidationRule
    {
        return new MaximunRule($param);
    }

    public static function minimun($param): ValidationRule
    {
        return new MinimunRule($param);
    }

    public static function number(): ValidationRule
    {
        return new NumberRule();
    }

    public static function string(): ValidationRule
    {
        return new StringRule();
    }
}
