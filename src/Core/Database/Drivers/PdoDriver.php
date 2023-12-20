<?php

namespace Src\Core\Database\Drivers;

use Src\Core\Database\Interfaces\DatabaseDriver;
use Src\Core\Database\Drivers\DatabaseConnection;

class PdoDriver implements DatabaseDriver
{
    protected DatabaseConnection $connection;

    public function connect(array $datosConexion)
    {
        $this->connection = new DatabaseConnection($datosConexion);
    }

    public function getDriver()
    {
        return $this->connection;
    }

    public function close()
    {
        $this->connection->close();
    }

    public function statement(string $query, array $binds = [])
    {
        return $this->connection->statement($query, $binds);
    }

    public function table($table)
    {
        return $this->connection->table($table);
    }

    public function all()
    {
        return 'all';
    }
}
