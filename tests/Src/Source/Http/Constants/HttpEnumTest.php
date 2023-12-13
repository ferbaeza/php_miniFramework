<?php

namespace Tests\Src\Source\Http\Constants;

use PHPUnit\Framework\TestCase;

class HttpEnumTest extends TestCase
{
    /**
     * @test
     * @group http
     * */
    public function enumHttp(): void
    {
        foreach (Http::getEnumHttpMetodos() as $metodo) {
            $this->assertTrue(Http::getEnumHttp($metodo));
        }
    }

    /**
     * @test
     * @group http
     * @dataProvider getEnumHttp
     * */
    public function enumHttpProvider(string $metodo): void
    {
        $this->assertTrue(Http::getEnumHttp($metodo));
        $this->assertSame($metodo, Http::getNameEnumHttp($metodo));
    }

    public static function getEnumHttp(): mixed
    {
        yield "Metodo GET" => ["GET"];
        yield "Metodo POST" => ["POST"];
        yield "Metodo PUT" => ["PUT"];
        yield "Metodo DELETE" => ["DELETE"];
    }
}
