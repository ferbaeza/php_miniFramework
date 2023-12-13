<?php

use Src\Core\Shared\Utils\Strings\StringUtils;

function snake(string $text): string
{
    return StringUtils::convertToSnakeCase($text);
}

function snakeToCamel(string $text): string
{
    return StringUtils::snakeToCamel($text);
}

function uuid(): string
{
    return StringUtils::uuid();
}

function capitalize(string $variable)
{
    return StringUtils::stringCapitalizada($variable);
}
