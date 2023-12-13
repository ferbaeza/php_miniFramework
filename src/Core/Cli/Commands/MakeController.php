<?php

namespace Src\Core\Cli\Commands;

use Src\Core\App;
use Src\Core\Shared\Utils\App\EnvUtils;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeController extends Command
{
    private const CONTROLLER_TEMPLATE = "ControllerName";
    private const CONTROLLER_PATH = "/app/Http/Controllers/";

    protected static $defaultName = "make:controller";
    protected static $defaultDescription = "Crea un Controllador";

    protected function configure()
    {
        $this->addArgument("nombre", InputArgument::REQUIRED, "ControllerName");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //* Hay que comprobar que el directorio exista de app/Http/Controllers */
        //* Hay que comprobar que el archivo NO exista en el Directorio*/


        $nombre = $input->getArgument("nombre");
        $ruta = "var/www/html5/src/Resources/Templates/".self::CONTROLLER_TEMPLATE.".php";
        $ruta = (migrationTemplate(self::CONTROLLER_TEMPLATE));
        $exist = file_exists($ruta);
        if ($exist) {
            $template = file_get_contents($ruta);
            $template = str_replace(self::CONTROLLER_TEMPLATE, $nombre, $template);
            // $controllerRuta = EnvUtils::srcFolder() . "/Backend/Controllers/$nombre.php";

            file_put_contents(main() . self::CONTROLLER_PATH."/$nombre.php", $template);
            $output->writeln("<info>Controller created => $nombre.php</info>");
        }
        return Command::SUCCESS;
    }
}
