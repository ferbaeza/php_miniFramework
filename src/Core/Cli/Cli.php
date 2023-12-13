<?php

namespace Src\Core\Cli;

use Src\Core\App;
use Dotenv\Dotenv;
use Src\Core\Config\Config;
use Src\Core\Cli\Commands\HelloWorld;
use Src\Core\Cli\Commands\MakeMigration;
use Src\Core\Cli\Commands\MakeController;
use Src\Core\Database\Migrations\Migrator;
use Symfony\Component\Console\Application;
use Src\Core\Cli\Commands\MigrateMigration;
use Src\Core\Cli\Commands\RollbackMigration;
use Src\Core\Database\Config\DataBaseConfig;
use Symfony\Component\VarDumper\Cloner\Data;
use Src\Core\Database\Drivers\DatabaseBuilder;
use Src\Core\Database\Interfaces\DatabaseDriver;

class Cli
{
    private static string $root;
    private static array $config;

    public static function bootstrap(string $root): self
    {
        self::$root = $root;
        self::loadConfig();
        self::loadContainer();
        return new self();
    }

    public static function run(): void
    {
        $cli = new Application("MiniFrame");
        $cli->addCommands([
            new HelloWorld(),
            new MakeController(),
            new MakeMigration(),
            new RollbackMigration(),
            new MigrateMigration(),
        ]);

        $cli->run();
    }

    protected static function loadContainer()
    {
        foreach (config('providers.cli') as $provider) {
            (new $provider())->register();
        }
        $data = DataBaseConfig::default();
        $driver = resolve(DatabaseDriver::class);
        $driver->connect($data);
        $driver->schema = new DatabaseBuilder($driver);


        singleton(Migrator::class, function () use ($driver) {
            return new Migrator(self::$root . "/app/database", $driver->schema);
        });

    }

    protected static function loadConfig()
    {
        Config::load(self::$root . '/app/config');
        $config = Config::getConfiguration();
        $dotenv = Dotenv::createImmutable(self::$root)->load();
        self::$config = array_merge($config, $dotenv);
        return self::$config;
    }
}
