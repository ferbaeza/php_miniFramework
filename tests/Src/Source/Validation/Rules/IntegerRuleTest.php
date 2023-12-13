<?php

namespace Tests\Src\Source\Validation\Rules;

use Src\Core\Validation\Rules\IntegerRule;
use Tests\TestCase;

/**
 * @group validation
 */
class IntegerRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_es_integer()
    {
        $field = 'integer';
        $data = [
            10 => true,
            '6.88' => false,
        ];
        foreach ($data as $value => $expected) {
            $rule = new IntegerRule();
            $this->assertEquals($expected, $rule->isValid($field, [$field => $value]));
        }
    }


}
