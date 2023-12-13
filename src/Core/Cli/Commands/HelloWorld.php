<?php

namespace Src\Core\Cli\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends Command
{
    protected static $defaultName = "say:hello";
    protected static $defaultDescription = "Print Hello World";

    protected function configure()
    {
        $this->addArgument("nombre", InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Hello World Command',
            '==================',
            "Hello {$input->getArgument("nombre")}",
        ]);
        return Command::SUCCESS;
    }
}
