<?php

namespace Tests\Src\Shared\Utils;

use Tests\TestCase;
use Src\Core\Shared\Utils\Strings\StringUtils;

class StringUtilsTest extends TestCase
{
    /**
     * @group utils
     * @test*/
    public function devuleve_un_nombre_en_mayusculas(): void
    {
        $actual = 'Fernando';
        $expected = 'FERNANDO';

        $this->assertSame($expected, StringUtils::mayusculas($actual));
    }

}
