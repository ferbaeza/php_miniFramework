<?php

namespace Src\Core\Database\Config;

class DataBaseConfig
{
    public static function loadConfig()
    {
        $config = app()->config;
        $driver = $config['config']['database']['default'];
        return [
            'driver' => $config['config']['database']['default'],
            'host' => $config['config']['database']['connections'][$driver]['host'],
            'port' => $config['config']['database']['connections'][$driver]['port'],
            'database' => $config['config']['database']['connections'][$driver]['database'],
            'username' => $config['config']['database']['connections'][$driver]['username'],
            'password' => $config['config']['database']['connections'][$driver]['password'],
        ];
    }

    public static function default()
    {
        return [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', 'postgres'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'fastphp'),
            'username' => env('DB_USERNAME', 'zataca'),
            'password' => env('DB_PASSWORD', 'zataca'),
        ];
    }

}
