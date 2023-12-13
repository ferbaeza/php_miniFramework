<?php

namespace Tests\Src\Source\Validation\Rules;

use Tests\TestCase;
use Src\Core\Validation\Rules\MaximunRule;

/**
 * @group validation
 */
class MaximunRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_es_el_max_permitido()
    {
        $field = 'max';
        $max = 7;
        $data = [
            10 => false,
            6 => true,
        ];
        foreach ($data as $value => $expected) {
            $rule = new MaximunRule($max);
            $this->assertEquals($expected, $rule->isValid($field, [$field => $value]));
        }
    }


}
