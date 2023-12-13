<?php

namespace Src\Core\Facades;

use Src\Core\App;
use Symfony\Component\VarDumper\Cloner\Data;
use Src\Core\Database\Interfaces\DatabaseDriver;

class DB
{
    private static $instance;

    public static function getInstance()
    {
        if(!self::$instance) {
            App::connect();
            // self::$instance = App::connect();
            // self::$instance = app()->database;
            self::$instance = resolve(DatabaseDriver::class);

        }
        return self::$instance;
    }

    public static function __callStatic($method, $arguments)
    {

        $instance = self::getInstance();
        return call_user_func_array([$instance, $method ], $arguments);
    }

}
