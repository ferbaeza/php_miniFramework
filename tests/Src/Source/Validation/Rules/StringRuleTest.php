<?php

namespace Tests\Src\Source\Validation\Rules;

use Src\Core\Validation\Rules\StringRule;
use Tests\TestCase;

/**
 * @group validation
 */
class StringRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_es_un_string()
    {
        $field = 'string';
        $data = [
            66 => false,
            'cadena' => true,
        ];
        foreach ($data as $value => $expected) {
            $rule = new StringRule();
            $this->assertEquals($expected, $rule->isValid($field, [$field => $value]));
        }
    }
}
