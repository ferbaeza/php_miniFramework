<?php

namespace Src\Core\Config;

use Src\Core\App;
use Dotenv\Dotenv;
use Src\Core\Config\Exceptions\ConfigNotFoundException;

class Config
{
    /**
     * $config es la configuracion de la aplicacion
     * @var array
     */
    private static array $config = [];

    /**
     * CONFIG_PATH es la ruta de la carpeta config
     */
    private const CONFIG_PATH = "/app/config";


    /**
     * load es un metodo para cargar las configuraciones
     * @param string $path
     * @return void
     */
    public static function load($path = null): void
    {
        $path = $path ?? App::$rootDirectory.self::CONFIG_PATH;
        foreach (glob("$path/*.php") as $config) {
            $key = explode(".", basename($config))[0];
            $values = require_once $config;
            self::$config[$key] = $values;
        }
    }

    /**
     * getConfiguration es un metodo para obtener todas las configuraciones
     * @return array
     */
    public static function getConfiguration()
    {
        return self::$config;
    }

    /**
     * get es un metodo para obtener una configuracion
     * @param  string $config
     * @return array|string
     */
    public static function get(string $config = 'app'): array|string
    {
        $temp = explode(".", $config);

        if(count($temp) === 1) {
            list($key) = $temp;
            if (!key_exists($key, self::$config)) {
                throw ConfigNotFoundException::create();
            }
            return self::$config[$config];
        }

        list($config, $key) = $temp;
        if (!key_exists($config, self::$config)) {
            throw ConfigNotFoundException::create();
        }
        if (!key_exists($key, self::$config[$config])) {
            throw ConfigNotFoundException::create();
        }
        return self::$config[$config][$key];
    }

    /**
     * bootstrap es un metodo para cargar las configuraciones
     * @param string $rootDirectory
     * @return array
     */
    public static function bootstrap(string $rootDirectory): array
    {
        $res = Dotenv::createImmutable($rootDirectory)->load();
        Config::load();
        $config = Config::getConfiguration();
        $data = [
            'env' => $res,
            'config' => $config,
            'app_name' => capitalize(config('app.app_name')),
            'user_email' => capitalize(config('app.user_email')),
            'user_name' => capitalize(config('app.user_name'))
        ];
        return $data;
    }
}
