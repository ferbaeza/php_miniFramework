<?php

namespace Src\Core\Shared\Utils\App;

use Src\Core\App;

class EnvUtils
{
    public static function env(string $variable, $default = null): string|null
    {
        return $_ENV[$variable] ?? $default;
    }

    public static function resourcesDirectory(): string
    {
        return App::$sourceFolder . "/Resources";
    }

    public static function templatePath(string $tring): string
    {
        return App::$sourceFolder . "/Resources/Templates/$tring.php";
    }

    public static function viewsPath(): string
    {
        return App::$rootDirectory . "/app/resources/views/";
    }

    public static function srcFolder(): string
    {
        return App::$sourceFolder;
    }

    public static function config(string $file): string
    {
        return App::$sourceFolder . "/Core/Config/config/$file.php";
    }
}
