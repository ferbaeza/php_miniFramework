<?php

namespace Tests\Src\Source\Validation\Rules;

use Tests\TestCase;
use Src\Core\Validation\Rules\RequiredRule;

/**
 * @group validation
 */
class RequiredTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test*/
    public function verificar_el_campo_requerido_rule()
    {
        $data = [
            null => false,
            false => false,
            'Hola' => true,
            6 => true,
        ];
        foreach ($data as $value => $expected) {
            $rule = new RequiredRule();
            $this->assertEquals($expected, $rule->isValid('nombre', ['nombre' => $value]));
        }
    }


}
