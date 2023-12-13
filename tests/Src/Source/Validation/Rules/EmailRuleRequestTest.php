<?php

namespace Tests\Src\Source\Validation\Rules;

use Tests\TestCase;
use Src\Core\Validation\Rules\EmailRule;

/**
 * @group validation
 */
class EmailRuleRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }



    public function testValidacionEmail()
    {
        $data = [
            '@mail' => false,
            'baeza@mail' => false,
            'b@aeza@mail' => false,
            'baeza@mail.com' => true,
            'ana@mail.ser.es' => true,
            'a@mail.org' => true,
        ];
        foreach ($data as $mail => $value) {
            $rule = new EmailRule();
            $this->assertEquals($value, $rule->isValid('email', ['email' => $mail]));
        }
    }

    public function testValidacionEmailSimple()
    {
        $dataFalse = ['email' => 'baeza@mail'];
        $data = ['email' => 'baeza@mail.com'];
        $rule = new EmailRule();

        $this->assertEquals(false, $rule->isValid('email', $dataFalse));
        $this->assertEquals(true, $rule->isValid('email', $data));
    }
}
