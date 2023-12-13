<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public static string $ROOT = __DIR__;

    protected function setUp(): void
    {
        self::$ROOT = dirname(__DIR__);
        parent::setUp();
    }
}
