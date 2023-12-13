<?php

namespace Src\Core\Cli\Commands;

use Src\Core\Database\Migrations\Migrator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeMigration extends Command
{
    protected static $defaultName = "make:migration";
    protected static $defaultDescription = "Crea una Migracion";

    protected function configure()
    {
        $this->addArgument("nombre", InputArgument::REQUIRED, "Nombre de la Migration");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        app(Migrator::class)->make($input->getArgument("nombre"));
        return Command::SUCCESS;
    }


}
