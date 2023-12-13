<?php

namespace Src\Core\Shared\Utils\Strings;

use Faker\Core\Uuid;

class StringUtils
{
    public static function mayusculas(string $string): string
    {
        return mb_strtoupper($string);
    }

    public static function stringCapitalizada(string $cadena)
    {
        $cadenaTrimeada = trim($cadena);
        $cadenaMinusculas = mb_strtolower($cadenaTrimeada, "UTF-8");
        $cadenaPascalCase = mb_convert_case($cadenaMinusculas, MB_CASE_TITLE, 'UTF-8');

        return trim($cadenaPascalCase);
    }

    public static function snakeToCamel(string $text): string
    {
        return str_replace('_', '', lcfirst(ucwords($text, '_')));
    }

    public static function convertToSnakeCase(string $text): string
    {
        // Reemplaza los espacios y los guiones por guiones bajos
        $text = preg_replace('/[\s-]/', '_', $text);

        // Reemplaza las letras mayúsculas por guiones bajos seguidos de la letra en minúscula
        $text = preg_replace('/([A-Z])/', '_$1', $text);

        // Convierte todo a minúsculas
        $text = strtolower($text);

        // Elimina los guiones bajos al principio de la cadena
        $text = ltrim($text, '_');

        return $text;
    }

    public static function uuid(): string
    {
        $u = new Uuid();
        return $u->uuid3();
    }
}
