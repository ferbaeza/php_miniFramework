<?php

namespace Src\Core\Facades;

use Src\Core\Database\Interfaces\DatabaseDriver;

class Schema
{
    private static $instance;

    public static function getInstance()
    {
        if(!self::$instance) {
            /**
             * To Test from client web from app->instance
             * self::$instance = app()->schema;
             */
            // self::$instance = app()->schema;
            self::$instance = app(DatabaseDriver::class)->schema;
        }
        return self::$instance;
    }

    public static function __callStatic($method, $arguments)
    {
        $instance = self::getInstance();
        return call_user_func_array([$instance, $method ], $arguments);
    }

}
