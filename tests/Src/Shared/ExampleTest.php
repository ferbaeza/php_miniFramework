<?php

namespace Tests\Src\Shared;

use Dotenv\Dotenv;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * @group example
     *  @test*/
    public function assert_true(): void
    {
        $this->assertTrue(true);
    }
}
