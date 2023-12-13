<?php

namespace Src\Core\Database\Drivers;

use PDO;
use PDOStatement;

class DatabaseConnection
{
    protected ?PDO $connection;
    protected string $table;
    protected string $fields = '*';
    protected string $operator = '=';
    protected array $wheres = [];

    public function __construct(
        public readonly array $datosConexion
    ) {
        $driver = $datosConexion['driver'];
        $host = $datosConexion['host'];
        $port = $datosConexion['port'];
        $database = $datosConexion['database'];
        $username = $datosConexion['username'];
        $password = $datosConexion['password'];
        $dsn = "$driver:host=$host;port=$port;dbname=$database";
        $this->connection = new PDO($dsn, $username, $password);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public function driver()
    {
        return $this->connection;
    }

    public function statement(string $query, array $binds = []): array
    {
        $statement = $this->prepare($query);
        // dd($statement, $binds);
        $response = $this->exec($statement, $binds);
        return $response;
    }

    public function exec(PDOStatement $statement, array $binds = []): array
    {
        $statement->execute($binds);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function prepare(string $query): PDOStatement
    {
        return $this->connection->prepare($query);
    }

    public function close()
    {
        $this->connection = null;
    }

    public function table(string $table)
    {
        $this->table = $table;
        return $this;
    }

    public function insert($table, string $columns, string $binds, array $values = [])
    {
        $sql = "INSERT INTO $table ($columns) VALUES ($binds)";
        return $this->statement($sql, $values);
    }

    // public function delete($table, string $columns, string $binds, array $values = [])
    // {
    //     dd($columns, $binds, $values);
    //     $sql = "DELETE FROM $table WHERE ($columns) VALUES ($binds)";
    //     return $this->statement($sql, $values);
    // }

    public function all(?string $table = null)
    {
        $table = $table ?? $this->table;
        $sql = "SELECT * FROM $table";
        return $this->statement($sql);
    }

    public function first(?string $table = null)
    {
        $table = $table ?? $this->table;
        $sql = "SELECT * FROM $table LIMIT 1";
        return $this->statement($sql);
    }

    public function find(?string $table = null, string $primaryKey, string|int $value)
    {
        $table = $table ?? $this->table;
        $sql = "SELECT * FROM $table WHERE  $primaryKey = ? LIMIT 1";
        return $this->statement($sql, [$value]);
    }

    public function select(...$fields)
    {
        $this->fields = (count($fields) > 1) ? implode(',', $fields) : $fields[0];
        return $this;
    }


    public function where(...$params)
    {
        dd($params);
        /** @phpstan-ignore-next-line */
        match(count($params)) {
            2 => list($column, $value) = $params,
            3 => list($column, $this->operator, $value) = $params,
        };
        $this->wheres[] = [
            'type' => 'AND',
            'column' => $column,
            'operator' => $this->operator,
            'value' => $value
        ];

        return $this;
    }

    public function orWhere(...$params)
    {
        /** @phpstan-ignore-next-line */
        match (count($params)) {
            2 => list($column, $value) = $params,
            3 => list($column, $this->operator, $value) = $params,
        };
        $this->wheres[] = [
            'type' => 'OR',
            /** @phpstan-ignore-next-line */
            'column' => $column,
            'operator' => $this->operator,
            /** @phpstan-ignore-next-line */
            'value' => $value
        ];

        return $this;
    }

    public function get()
    {
        $sql = "SELECT $this->fields FROM $this->table";
        if(!empty($this->wheres)) {
            $sql .= " WHERE ";
            foreach($this->wheres as $index => $where) {
                if($index > 0) {
                    $sql .= " {$where['type']} ";
                }
                $sql .= "{$where['column']} {$where['operator']} ?";
            }
        }
        /** @phpstan-ignore-next-line */
        $bindValues = array_column($this->wheres, 'value') ?? [];
        return $this->statement($sql, $bindValues);

    }

}
