<?php

namespace Src\Core\Validation;

use Src\Core\Validation\Rules\EmailRule;
use Src\Core\Validation\Rules\FloatRule;
use Src\Core\Validation\Rules\NumberRule;
use Src\Core\Validation\Rules\StringRule;
use Src\Core\Validation\Rules\IntegerRule;
use Src\Core\Validation\Rules\MaximunRule;
use Src\Core\Validation\Rules\MinimunRule;
use Src\Core\Validation\Rules\RequiredRule;
use Src\Core\Validation\Rules\RequiredWithRule;
use Src\Core\Validation\Exceptions\ValidationException;

class Validator
{
    protected array $data;
    public function __construct(
        array $data,
    ) {
        $this->data = $data;
    }

    protected static $rulesMap = [
        'required' => RequiredRule::class,
        'required_with' => RequiredWithRule::class,
        'email' => EmailRule::class,
        'number' => NumberRule::class,
        'string' => StringRule::class,
        'min' => MinimunRule::class,
        'max' => MaximunRule::class,
        'integer' => IntegerRule::class,
        'float' => FloatRule::class,
    ];

    public function validate(array $rules, array $messages = []): array
    {
        $ruleInstance = null;
        $value = null;
        $errors = [];
        $validados = [];
        $data = [];

        foreach ($rules as $field => $rule) {
            $rulesArray = explode('|', $rule);
            foreach ($rulesArray as $ruleRequest) {
                $parts = explode(':', $ruleRequest, 2);
                $ruleName = $parts[0];
                $parametro = $parts[1] ?? null;
                if(isset(self::$rulesMap[$ruleName])) {
                    $ruleInstance = ($parametro === null) ?
                    (new self::$rulesMap[$ruleName]()) : (new self::$rulesMap[$ruleName]($parametro));

                    $value = $this->data[$field] ?? null;
                }

                if(!$ruleInstance->isValid($field, $this->data)) {
                    $this->prepareErrors($field, $ruleName, $messages, $errors, $ruleInstance);
                } else {
                    $data[$field] = $value;
                    $validados[$field][$ruleName] = $value;
                }
            }
        }
        if(!empty($errors)) {
            throw new ValidationException($errors);
        }
        return ['data' => $data, "validados" => $validados];
    }

    private function prepareErrors(string $field, string $ruleName, array $messages, array &$errors, $ruleInstance)
    {
        $mensaje = $messages[$field][$ruleName] ?? $ruleInstance->message($field);
        $errors[$field][$ruleName] = $mensaje;
        $this->data['filed_with_error'] = $field;
        $this->data['msg'] = $mensaje;
        session()->flash('_old', ['data' => $this->data]);
    }
}
