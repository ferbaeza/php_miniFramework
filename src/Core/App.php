<?php

namespace Src\Core;

use Src\Core\Config\Config;
use Src\Core\Routing\Router;
use Src\Core\Session\Session;
use Src\Core\Views\ViewsEngine;
use Src\Core\Container\Container;
use Src\Core\Database\Model\Model;
use Src\Core\Http\Request\Request;
use Src\Core\Http\Server\PhpServer;
use Src\Core\Http\Response\Response;
use Src\Core\Http\Response\ApiResponse;
use Src\Core\Http\Constants\HttpMetodos;
use Src\Core\Http\Server\Interfaces\Server;
use Src\Core\Database\Config\DataBaseConfig;
use Src\Core\Views\Interfaces\ViewInterface;
use Src\Core\Database\Drivers\DatabaseBuilder;
use Src\Core\Session\Interfaces\SessionStorage;
use Src\Core\Database\Interfaces\DatabaseDriver;
use Src\Core\Http\Exceptions\HttpNotFoundException;
use Src\Core\Validation\Exceptions\ValidationException;

class App
{
    /**
     * $rootDirectory es la ruta de la aplicacion
     * @var string
     */
    public static string $rootDirectory;

    /**
     * $sourceFolder es la ruta del core del proyecto
     * @var string
     */
    public static string $sourceFolder;

    /**
     * router es la instancia de Router
     * @var Router
     */
    public Router $router;

    /**
     * request es la instancia de Request
     * @var Request
     */
    public Request $request;

    /**
     * server es la instancia de PhpServer
     * @var PhpServer
     */
    public PhpServer $server;

    /**
     * server es la instancia de PhpServer
     * @var array
     */
    public array $config = [];

    /**
     * viewsEngine es la instancia de ViewsEngine
     * @var ViewsEngine
     */
    public ViewsEngine $viewsEngine;

    /**
     * session es la instancia de Session
     * @var Session
     */
    public Session $session;

    /**
     * database es la instancia de DatabaseDriver
     * @var DatabaseDriver
     */
    public DatabaseDriver $database;

    /**
     * schema es la instancia de DatabaseBuilder
     * @var DatabaseBuilder
     */
    public DatabaseBuilder $schema;


    /**
     * bootstrap es el metodo que inicia la aplicacion
     * en la cual usamos el patron singleton para crear
     * una instancia de App 
     * @param string $root
     */
    public static function bootstrap(string $root)
    {
        self::$rootDirectory = $root;
        self::$sourceFolder = dirname(__DIR__);
        $app = Container::singleton(self::class);

        $app->loadConfig()
            ->runServiceProviders('boot')
            ->setHttpHandlers()
            // ->setDatabaseConnection()
            ->setViewEngine()
            ->runServiceProviders('runtime');

        return $app;
    }


    /**
     * run es el metodo que ejecuta la aplicacion
     * @return void
     */
    public function run()
    {
        try {
            // $request = ($this->server->getRequest());
            $response = $this->router->resolve($this->server->getRequest());
            $this->terminate($response);
        } catch (HttpNotFoundException) {
            $response = Response::text('Not Found', Response::ESTADO_404);
            $this->terminate($response);
        } catch (ValidationException $e) {
            $response = ApiResponse::json(['e' => $e->errores(), 'old' => oldSession()], ApiResponse::ESTADO_400_ERROR);
            $this->terminate($response);
        }
    }

    public function prepareNextRequest()
    {
        if ($this->request->metodo() === HttpMetodos::GET) {
            $this->session->set('_previous', $this->request->uri());
        }
    }

    /**
     * terminate es el metodo que finaliza la aplicacion
     * @param  Response $response
     * @return void
     */
    public function terminate(Response $response): void
    {
        $this->prepareNextRequest();
        $this->server->sendResponse($response);
        if(isset($this->database)) {
            $this->database->close();
        };
        exit();
    }

    /**
     * loadConfig es el metodo que carga las configuraciones en la instancia de app
     * @return self
     */
    protected function loadConfig(): self
    {
        $data = Config::bootstrap(self::$rootDirectory);
        app()->config = $data;
        return  $this;
    }

    /**
     * runServiceProviders es el metodo que ejecuta los service providers
     * @param  string $type
     * @return self
     */
    protected function runServiceProviders(string $type): self
    {
        foreach (config("providers.$type") as $provider) {
            $provider = new $provider();
            if (method_exists($provider, 'register')) {
                $provider->register();
            }
        }
        return $this;
    }

    /**
     * setHttpHandlers es el metodo que crea las instancias de los handlers http Router, Request, Session
     * @return self
     */
    protected function setHttpHandlers(): self
    {
        $this->router = singleton(Router::class);
        $this->server = app(Server::class);
        $this->request = singleton(Request::class, fn () => $this->server->getRequest());
        $this->session = singleton(Session::class, fn () => new Session(app(SessionStorage::class)));
        return $this;
    }

    /**
     * setDatabaseConnection es el metodo que crea la conexion de la aplicacion a la base de datos y crea las instancias de DatabaseBuilder y DatabaseDriver
     * @return self
     */
    protected function setDatabaseConnection(): self
    {
        $this->database = app(DatabaseDriver::class);
        $this->database->connect(self::connectionDBData());
        $this->schema = new DatabaseBuilder($this->database);
        /** @phpstan-ignore-next-line */
        Model::setDataBaseDriver(($this->database));
        return $this;
    }

    /**
     * connect es el metodo que crea la conexion de la aplicacion a la base de datos desde otars partes de la aplicacion
     * @return void
     */
    public static function connect()
    {
        /** @phpstan-ignore-next-line */
        (new static())->setDatabaseConnection();
    }

    /**
     * connectionDBData es el metodo que obtiene los datos de conexion a la base de datos
     * @return array
     */
    protected static function connectionDBData()
    {
        return DataBaseConfig::loadConfig();
    }

    /**
     * setViewEngine es el metodo que crea la instancia de ViewsEngine
     * @return self
     */
    protected function setViewEngine(): self
    {
        $this->viewsEngine = singleton(ViewInterface::class, fn () => new ViewsEngine(resourcesViews()));
        return $this;
    }

}
