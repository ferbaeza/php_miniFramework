<?php

namespace Tests\Src\Source\Validation\Rules;

use Src\Core\Validation\Rules\FloatRule;
use Tests\TestCase;

/**
 * @group validation
 */
class FloatRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_es_float()
    {
        $field = 'float';
        $data = [
            10 => false,
            '6.88' => true,
        ];
        foreach ($data as $value => $expected) {
            $rule = new FloatRule();
            $this->assertEquals($expected, $rule->isValid($field, [$field => $value]));
        }
    }


}
