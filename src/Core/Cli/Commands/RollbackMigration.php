<?php

namespace Src\Core\Cli\Commands;

use Src\Core\Database\Migrations\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RollbackMigration extends Command
{
    protected static $defaultName = "migration:rollback";
    protected static $defaultDescription = "Crea una Migracion";

    protected function configure()
    {
        $this->addArgument("cantidad", InputArgument::OPTIONAL, "Cantidad de rollback");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        app(Migrator::class)->rollback($input->getArgument("cantidad"));
        return Command::SUCCESS;
    }


}
