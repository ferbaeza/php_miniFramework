<?php

use Src\Core\App;
use Src\Core\Config\Config;
use Src\Core\Container\Container;
use Src\Core\Shared\Utils\App\EnvUtils;

/**
 * env es un helper para obtener variables de entorno
 * @param  string $variable
 * @param  string $default
 * @return string|null
 */
function env(string $variable, string $default = null): string|null
{
    return EnvUtils::env($variable, $default);
}

/**
 * app es un helper para obtener la instancia de App
 * @param  string $class
 * @return mixed
 */
function app(string $class = App::class): mixed
{
    return Container::resolve($class);
}

/**
 * singleton es un helper para registrar una instancia en el contenedor
 * @param  string $class
 * @param  string|callable|null $build
 */
function singleton(string $class, string|callable|null $build = null)
{
    return Container::singleton($class, $build);
}

/**
 * resolve es un helper para obtener una instancia del contenedor
 * @param  string $class
 */
function resolve(string $class)
{
    return Container::resolve($class);
}

/**
 * config es un helper para obtener una configuracion
 * @param  string $config
 * @return array|string
 */
function config(string $config = 'app'): array|string
{
    return Config::get($config);
}

/**
 * allConfig es un helper para obtener todas las configuraciones
 * @return array
 */
function allConfig(): array
{
    return Config::getConfiguration();
}

/**
 * instances es un helper para obtener todas las instancias del contenedor
 * @return array
 */
function instances(): array
{
    return Container::getInstances();
}

/**
 * resourcesViews es un helper para obtener la ruta de las vistas
 * @return string
 */
function resourcesViews(): string
{
    return EnvUtils::viewsPath();
}
