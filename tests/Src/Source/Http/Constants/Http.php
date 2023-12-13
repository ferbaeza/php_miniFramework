<?php

namespace Tests\Src\Source\Http\Constants;

use Src\Core\Shared\Utils\Strings\StringUtils;

class Http
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';

    public static function getEnumHttp(string $metodo): bool
    {
        if (in_array($metodo, self::getEnumHttpMetodos())) {
            return true;
        }
        return false;
    }

    public static function getNameEnumHttp(string $metodo): string
    {
        if (in_array($metodo, self::getEnumHttpMetodos())) {
            return StringUtils::mayusculas($metodo);
        }
        return "None";
    }

    public static function getEnumHttpMetodos(): mixed
    {
        return [
            self::GET,
            self::POST,
            self::PUT,
            self::DELETE,
        ];
    }
}
