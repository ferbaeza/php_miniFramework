<?php

namespace Tests\Src\Source\Validation\Rules;

use Src\Core\Validation\Rules\MinimunRule;
use Tests\TestCase;

/**
 * @group validation
 */
class MinimunRuleTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_es_el_min_permitido()
    {
        $field = 'min';
        $min = 2;
        $data = [
            1 => false,
            3 => true,
        ];
        foreach ($data as $value => $expected) {
            $rule = new MinimunRule($min);
            $this->assertEquals($expected, $rule->isValid($field, [$field => $value]));
        }
    }


}
