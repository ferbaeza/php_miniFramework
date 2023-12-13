<?php

namespace Src\Core\Cli\Commands;

use Src\Core\Database\Migrations\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateMigration extends Command
{
    protected static $defaultName = "migration:migrate";
    protected static $defaultDescription = "Ejecuta las Migraciones";


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        app(Migrator::class)->migrate();
        return Command::SUCCESS;
    }


}
