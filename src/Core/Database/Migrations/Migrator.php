<?php

namespace Src\Core\Database\Migrations;

use Src\Core\Database\Drivers\DatabaseBuilder;
use Symfony\Component\Console\Output\ConsoleOutput;

class Migrator
{
    protected $connection;
    private const EXT = ".php";
    private ConsoleOutput $output;
    private const MIGRATIONS_LOGS = "/logs";
    private const TEMPLATE = "MigrationName";
    private const MIGRATIONS_TABLE = "migrations";
    private const MIGRATIONS_FOLDER = "/migrations";


    public function __construct(
        private string $migrationsDataBase,
        private DatabaseBuilder $databaseBuilder
    ) {
        $this->connection = $this->databaseBuilder;
        $this->output = new ConsoleOutput();
    }

    public function make(string $migrationName, bool $flag = true)
    {
        $migrationName = snake($migrationName);
        $template = migrationTemplate(self::TEMPLATE);
        $template = file_get_contents($template);

        if(preg_match('/create_.*_table/', $migrationName)) {
            $table =  preg_replace_callback('/create_(.*)_table/', function ($matches) {
                return $matches[1];
            }, $migrationName);
            $template = str_replace('$TABLE', $table, $template);
        }
        if (preg_match('/.*(from|to)_(.*)_table/', $migrationName) || preg_match('/add_.*_table/', $migrationName)) {
        } else {
        }

        $fileName = $this->fileName($migrationName.self::EXT);
        file_put_contents($this->migrationsDataBase.self::MIGRATIONS_FOLDER. "/$fileName", $template);
        $this->log("<info>Migracion $migrationName creada correctamente</info>");

        return $fileName;
    }

    private function fileName(string $migrationName)
    {
        $fecha = date("Y_m_d");
        $id = 0;
        $migrationsFiles = $this->migrationsFiles();
        foreach ($migrationsFiles as $file) {
            if (str_starts_with(basename($file), $fecha)) {
                $id++;
            }
        }
        $fileName = "$fecha"."_$id"."_$migrationName";
        $fileName = sprintf("%s_%07d_%s", $fecha, $id, $migrationName);
        return snake($fileName);
    }

    public function migrate()
    {
        $this->createMigrationTableIfNotExist();
        $migrated = $this->getCollectionMigrations();
        $migrationsFiles = $this->migrationsFiles();

        if(count($migrated) >= count($migrationsFiles)) {
            $this->log("<comment>Nothing_to_migrate</comment>");
            return;
        }
        foreach (array_slice($migrationsFiles, count($migrated)) as $file) {
            $migration = require $file;
            $migration->up();
            $this->connection->table(self::MIGRATIONS_TABLE)
                ->insert('id, name', '?, ?', [uuid(), basename($file)]);
            $fileNameToPrint = basename($file);
            $this->log("<info>Migration $fileNameToPrint  creada correctamente</info>" . PHP_EOL);
        }
    }


    public function rollback(?int $num = null)
    {
        $this->createMigrationTableIfNotExist();
        $migrated = $this->getCollectionMigrations();
        $migrationsFiles = $this->migrationsFiles();

        $migratedTotal = count($migrated);
        if($migratedTotal == 0) {
            $this->log("<comment>Nothing_to_rollback</comment>");
            return;
        }

        if(is_null($num) || $num > $migratedTotal) {
            $num = $migratedTotal;
        }
        $migrations = array_slice(($migrationsFiles), -$num);

        foreach ($migrations as $file) {
            $migration = require $file;
            $migration->down();
            $fileNameToPrint = basename($file);
            $this->connection->table(self::MIGRATIONS_TABLE)
                ->where('nombre', $fileNameToPrint)
                ->deleteMigration($fileNameToPrint);
            $this->log("<info>Migration $fileNameToPrint eliminada correctamente</info>" . PHP_EOL);

            if(--$num == 0) {
                break;
            }
        }
    }

    public function getCollectionMigrations()
    {
        return $this->connection->table(self::MIGRATIONS_TABLE)->all();
    }

    private function createMigrationTableIfNotExist()
    {
        $this->connection->createMigrationsTable(self::MIGRATIONS_TABLE);
    }

    private function migrationsFiles()
    {
        return glob("$this->migrationsDataBase" . self::MIGRATIONS_FOLDER . "/*.php");
    }

    private function log(string $message)
    {
        $fecha = date("Y-m-d");
        $newFecha = date("Y-m-d H:i:s");

        $menLog = "[$newFecha]-$message";
        $fileLog = $this->migrationsDataBase . self::MIGRATIONS_LOGS . "/$fecha.txt";
        if(file_exists($fileLog)) {
            file_put_contents($fileLog, $menLog . PHP_EOL, FILE_APPEND);
        } else {
            file_put_contents($fileLog, $menLog . PHP_EOL);
        }
        $this->output->writeln($message);
    }
}
