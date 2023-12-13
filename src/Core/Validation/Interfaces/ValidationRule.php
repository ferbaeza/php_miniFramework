<?php

namespace Src\Core\Validation\Interfaces;

/**
 * ValidationRule es la interfaz que deben implementar las reglas de validacion
 */
interface ValidationRule
{
    /**
     * message es el mensaje de error que se mostrara en caso de que la validacion falle
     * @param  string $field
     * @return string
     */
    public function message(string $field): string;

    /**
     * isValid es el metodo que se encarga de validar el campo
     * @param  string $value
     * @param  array  $data
     * @return bool
     */
    public function isValid(string $value, array $data = []): bool;
}
