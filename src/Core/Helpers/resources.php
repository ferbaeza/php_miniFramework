<?php

use Src\Core\App;

/**
 * resourcesDirectory es un helper para obtener la ruta de la carpeta resources del proyecto
 * @return string
 */
function resourcesDirectory(): string
{
    return App::$rootDirectory . "/resources";
}

/**
 * migrationTemplate es un helper para obtener la ruta de la carpeta resources del framework
 * @param  string $string
 * @return string
 */
function migrationTemplate(string $string): string
{
    /** @phpstan-ignore-next-line */
    $folder = SRC_FOLDER . "/Core/Resources/Templates/$string.php";
    return $folder;
}

/**
 * src es un helper para obtener la ruta de la carpeta src del framework
 * @return string
 */
function src(): string
{
    /** @phpstan-ignore-next-line */
    return SRC_FOLDER;
}

/**
 * main es un helper para obtener la ruta de la carpeta raiz del proyecto cuando accedemos desde el cliente de consola
 * @return string
 */
function main(): string
{
    /** @phpstan-ignore-next-line */
    return ROOT_FOLDER;
}
