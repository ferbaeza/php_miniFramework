<?php

namespace Src\Core\Database\Drivers;

class DatabaseBuilder
{
    protected string $table;
    protected $connection;
    protected array $values = [];

    public function __construct(
        public PdoDriver $databaseConnection
    ) {
        $this->connection = $databaseConnection->getDriver();
    }

    public function create()
    {
        $table = $this->table;
        $values = implode(',', $this->values);
        $values = "($values);";
        $this->createTableIfNotExist($table, $values);
    }

    public function all(?string $table = null)
    {
        $table = $table ?? $this->table;
        return $this->connection->all($table);
    }

    public function insert(string $columns, string $binds, array $values = [])
    {
        $table = $this->table;
        $this->connection->table($table)->insert($table, $columns, $binds, $values);
    }

    public function table(string $table): self
    {
        $this->table = $table;
        $this->values = [];
        return $this;
    }

    public function where(...$params): self
    {
        $this->connection->where(...$params);
        return $this;
    }

    public function deleteMigration(string $name): self
    {
        $sql = "DELETE FROM $this->table WHERE name = ?";
        $this->connection->statement($sql, [$name]);
        return $this;
    }

    public function uuid($column = 'id'): self
    {
        $this->values[$column] = "$column uuid PRIMARY KEY";
        return $this;
    }

    public function integer($column, $length = '4', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column INT$length DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column INT$length";
        return $this;
    }

    public function bigInteger($column, $length = '8', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column BIGINT($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column BIGINT($length)";
        return $this;
    }

    public function tinyInteger($column, $length = '1', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column TINYINT($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column TINYINT($length)";
        return $this;
    }

    public function smallInteger($column, $length = '2', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column SMALLINT($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column SMALLINT($length)";
        return $this;
    }

    public function mediumInteger($column, $length = '3', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column MEDIUMINT($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column MEDIUMINT($length)";
        return $this;
    }

    public function decimal($column, $length = '8', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column DECIMAL($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column DECIMAL($length)";
        return $this;
    }

    public function float($column, $length = '4', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column FLOAT($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column FLOAT($length)";
        return $this;
    }

    public function double($column, $length = '8', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column DOUBLE($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column DOUBLE($length)";
        return $this;
    }

    public function boolean($column, $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column BOOLEAN DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column BOOLEAN";
        return $this;
    }

    public function text($column): self
    {
        $this->values[$column] = "$column TEXT";
        return $this;
    }

    public function string($column, $length = '255', $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column VARCHAR($length) DEFAULT '$default'";
            return $this;
        }
        $this->values[$column] = "$column VARCHAR($length)";
        return $this;
    }

    public function date(string $column, ?bool $default = false): self
    {
        if ($default) {
            $this->values[$column] = "$column DATE DEFAULT CURRENT_TIMESTAMP";
            return $this;
        }
        $this->values[$column] = "$column DATE";
        return $this;
    }

    public function timestamps(?string $created = 'created_at', ?string $updated = 'updated_at'): self
    {
        $this->values[$created] = "$created TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        $this->values[$updated] = "$updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP";
        return $this;
    }

    public function createTableIfNotExist(string $table, string $values)
    {
        $sql = "CREATE TABLE IF NOT EXISTS $table $values";
        return $this->connection->statement($sql);
    }

    public function dropIfExists(string $table)
    {
        $sql = "DROP TABLE IF EXISTS $table";
        return $this->connection->statement($sql);
    }

    public function createMigrationsTable(string $table)
    {
        $this->values = [
            'id' => 'id uuid PRIMARY KEY',
            'name' => 'name VARCHAR',
            'created_at' => 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        ];
        $values = implode(',', $this->values);
        $values = "($values);";
        $this->createTableIfNotExist($table, $values);
    }

    public function dropTable(string $table)
    {
        $sql = "DROP TABLE IF EXISTS $table";
        $this->connection->statement($sql);
    }


}
