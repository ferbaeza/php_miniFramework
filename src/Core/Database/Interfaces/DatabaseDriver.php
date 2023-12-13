<?php

namespace Src\Core\Database\Interfaces;

interface DatabaseDriver
{
    public function connect(array $datosConexion);
    public function close();
    public function statement(string $query, array $binds = []);
}
