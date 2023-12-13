<?php

namespace Tests\Src\Shared\Utils;

use Dotenv\Dotenv;
use Tests\TestCase;

class EnvUtilsTest extends TestCase
{
    /**
     * @group utils
     *  @test*/
    public function dotenv_variables_testcase(): void
    {
        $dotenv = Dotenv::createImmutable(parent::$ROOT)->load();
        $name = $dotenv['APP_NAME'];
        $expected = env('APP_NAME');

        $this->assertSame($name, $expected);
    }
}
