<?php

namespace Src\Core\Database\Model;

use Src\Core\App;
use Src\Core\Database\Drivers\PdoDriver;
use Src\Core\Database\Config\DataBaseConfig;
use Src\Core\Database\Interfaces\DatabaseDriver;
use Src\Core\Database\Drivers\DatabaseConnection;
use Src\Core\Database\Exceptions\FillableModelException;

/**
 * Class Model
 *
 * @package Src\Core\Database\Model
 * @method static setDataBaseDriver(DatabaseConnection $connection) singleton app->database->driver
 * @method static create(array $attributes) create new model
 * @method protected fill(array $attributes) fill the atributes array
 * @method protected setAttributes(array $attributes) set the atributes array
 * @method public save() save the created model
 * @method static first()
 * @method static find(string|int $value)
 */
abstract class Model
{
    protected ?string $table = null;
    protected string $primaryKey = 'id';
    protected array $fillable = [];
    protected array $hidden = [];
    protected array $attributes = [];
    private static ?DatabaseConnection $connection = null;

    public function __construct()
    {
        if(is_null($this->table)) {
            $this->table = strtolower((new \ReflectionClass($this))->getShortName());
        }
    }

    public static function setDataBaseDriver(PdoDriver $connection)
    {
        return self::$connection = $connection->getDriver();
    }

    public static function getConnection()
    {
        if(is_null(self::$connection)) {
            App::connect();
            $app = resolve(DatabaseDriver::class);
            $app->connect(DataBaseConfig::loadConfig());
            self::$connection = $app->getDriver();
        }
        return self::$connection;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function save(): static
    {
        self::getConnection();
        $columns = implode(',', array_keys($this->attributes));
        $values = implode(',', array_fill(0, count($this->attributes), '?'));
        self::$connection->insert($this->table, $columns, $values, array_values($this->attributes));
        return $this;
    }

    public static function create(array $attributes): static
    {
        /** @phpstan-ignore-next-line */
        return (new static())->fill($attributes)->save();
    }

    protected function fill(array $attributes): static
    {
        if(empty($this->fillable)) {
            throw FillableModelException::create();
        }
        foreach($attributes as $key => $value) {
            if(in_array($key, $this->fillable)) {
                $this->__set($key, $value);
            }
        }
        return $this;
    }

    protected function setAttributes(array $attributes): static
    {
        foreach ($attributes as $key => $value) {
            $this->__set($key, $value);
        }

        return $this;
    }

    /**
     * Return the attributes array
     * @return array
     */
    public function toArray(): array
    {
        return array_filter($this->attributes, function ($key) {
            return !in_array($key, $this->hidden);
        }, ARRAY_FILTER_USE_KEY);

    }

    public static function all()
    {
        self::getConnection();
        /** @phpstan-ignore-next-line */
        $model = new static();
        $rows =  self::$connection->all($model->table);
        if ($rows == 0) {
            return [];
        }
        return $model->setAttributes($rows);
    }

    public static function first(): static|array
    {
        self::getConnection();
        /** @phpstan-ignore-next-line */
        $model = new static();
        $rows = self::$connection->first($model->table);
        if ($rows == 0) {
            return [];
        }
        /** @phpstan-ignore-next-line */
        return $model->setAttributes($rows);
    }

    public static function find(string|int $value): static|array
    {
        self::getConnection();
        /** @phpstan-ignore-next-line */
        $model = new static();
        $rows = self::$connection->find($model->table, $model->primaryKey, $value);

        if ($rows == 0) {
            return [];
        }
        $model->setAttributes($rows);
        return $model;
    }
}
