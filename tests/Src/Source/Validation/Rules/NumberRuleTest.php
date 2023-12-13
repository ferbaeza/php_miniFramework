<?php

namespace Tests\Src\Source\Validation\Rules;

use Tests\TestCase;
use Src\Core\Validation\Rules\NumberRule;

/**
 * @group validation
 */
class NumberRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_es_numerico()
    {
        $field = 'number';
        $data = [
            'jkbkhjgk' => false,
            6 => true,
        ];
        foreach ($data as $value => $expected) {
            $rule = new NumberRule();
            $this->assertEquals($expected, $rule->isValid($field, [$field => $value]));
        }
    }


}
