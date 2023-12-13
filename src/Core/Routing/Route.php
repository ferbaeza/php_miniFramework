<?php

namespace Src\Core\Routing;

use Closure;
use Src\Core\Config\Config;
use Src\Core\Helpers\Helper;
use Src\Core\Shared\Utils\App\EnvUtils;
use Src\Core\Http\Middlewares\Middlewares;

class Route
{
    protected string $uri;
    protected Closure|array $action;
    protected string $regex;
    protected array $parametros;

    /**
     * Middlewares
     * @var array
     */
    protected array $middlewares = [];

    public function __construct(
        string $uri,
        Closure|array $action
    ) {
        $this->uri = $uri;
        $this->action = $action;
        // Expresión regular para parsear los parámetros
        $this->regex = preg_replace(
            "/\{([a-zA-Z0-9_]+)\}/",
            "([a-zA-Z0-9_]+)",
            str_replace("/", "\/", $uri)
        );

        // Parsear los parámetros
        preg_match_all("/\{([a-zA-Z0-9_]+)\}/", $uri, $matches);
        $this->parametros = $matches[1];
    }

    public static function loadRoutes(string $rootDirectory)
    {
        foreach (glob("$rootDirectory/*.php") as $route) {
            require_once $route;
        }
    }

    public function uri()
    {
        return $this->uri;
    }

    public function action()
    {
        return $this->action;
    }

    public function parametros()
    {
        return $this->parametros;
    }

    public function middlewares()
    {
        return $this->middlewares;
    }

    public function setMiddleware(array $middlewares): self
    {
        $this->middlewares = array_map(fn ($middleware) => new $middleware(), $middlewares);
        return $this;
    }

    public function middleware(...$middleware): self
    {
        $config = (app()->config['config']['middlewares']);
        $this->middlewares = array_map(fn ($middlewareItem) => new $config[$middlewareItem](), $middleware);
        return $this;
    }

    public function hasMiddlewares(): bool
    {
        return count($this->middlewares) > 0;
    }

    public function matches(string $uri)
    {
        return preg_match("/^{$this->regex}$/", $uri);
    }

    public function hasParametros(): bool
    {
        return count($this->parametros) > 0;
    }

    public function parseaParametros(string $uri): mixed
    {
        preg_match("/^{$this->regex}$/", $uri, $valores);
        return array_combine($this->parametros, array_slice($valores, 1));
    }


    public static function get(string $uri, Closure|array $action): Route
    {
        return app()->router->get($uri, $action);
    }

    public static function post(string $uri, Closure|array $action): Route
    {
        return app()->router->post($uri, $action);
    }

    public static function put(string $uri, Closure|array $action): Route
    {
        return app()->router->put($uri, $action);
    }

    public static function delete(string $uri, Closure|array $action): Route
    {
        return app()->router->delete($uri, $action);
    }
}
