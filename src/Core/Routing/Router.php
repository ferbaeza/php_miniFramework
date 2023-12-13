<?php

namespace Src\Core\Routing;

use Closure;
use Src\Core\Routing\Route;
use Src\Core\Container\Container;
use Src\Core\Http\Request\Request;
use Src\Core\Http\Response\Response;
use Src\Core\Shared\Utils\App\EnvUtils;
use Src\Core\Http\Constants\HttpMetodos;
use Src\Core\Shared\Utils\Strings\StringUtils;

class Router
{
    protected array $routes = [];

    public function __construct()
    {
        foreach (HttpMetodos::cases() as $metodo) {
            $this->routes[$metodo->value] = [];
        }
    }

    public function get(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute(HttpMetodos::GET, $uri, $action);
    }

    public function post(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute(HttpMetodos::POST, $uri, $action);
    }

    public function put(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute(HttpMetodos::PUT, $uri, $action);
    }

    /**
     * Register a DELETE route
     * @param  string   $uri
     * @param  Closure|array $action
     * @return Route
     */
    public function delete(string $uri, Closure|array $action): Route
    {
        return $this->registerRoute(HttpMetodos::DELETE, $uri, $action);
    }

    /**
     * Start the application
     * @return void
     */
    public static function start()
    {
        $appName = StringUtils::stringCapitalizada(EnvUtils::env('APP_NAME'));
        $user = StringUtils::stringCapitalizada(EnvUtils::env('USER_NAME'));
        $email = (EnvUtils::env('USER_EMAIL'));
        printf(("$appName $user $email" . PHP_EOL));
    }

    /**
     * Register a route
     * @param  HttpMetodos   $metodo
     * @param  string        $uri
     * @param  Closure|array $action
     * @return Route
     */
    protected function registerRoute(HttpMetodos $metodo, string $uri, Closure|array $action): Route
    {
        $route = new Route($uri, $action);
        $this->routes[$metodo->value][] = $route;
        return $route;
    }


    /**
     * Resolve the route
     * @param  Request $request
     */
    public function resolveRoute(Request $request)
    {
        $uri = $request->uri();
        $metodo = $request->metodo()->value;
        foreach ($this->routes[$metodo] as $route) {
            if ($route->matches($uri)) {
                return $route;
            }
        }
    }

    /**
     * Run the middlewares
     * @param  Request  $request
     * @param  array    $middlewares
     * @param  Closure $action
     * @return Response
     */
    protected function runMiddlewares(Request $request, array $middlewares, Response|Closure $action): Response
    {
        if  (count($middlewares) === 0) {
            match(true) {
                is_callable($action) => $action = $action($request),
                is_object($action) => $action = $action,
            };
            return $action;
        }

        return $middlewares[0]->handle($request, fn ($request) => $this->runMiddlewares($request, array_slice($middlewares, 1), $action));
    }


    /**
     * Resolve the route
     * @param  Request $request
     * @return Response
     */
    public function resolve(Request $request): Response
    {
        $route = $this->resolveRoute($request);
        $request->setRoute($route);
        $action = $route->action();

        if(is_array($action)) {
            $controller = $action[0];
            $method = $action[1];

            $action = Container::build($controller);
            $action = call_user_func_array([$action, $method], [$request]);
        }

        return $this->runMiddlewares(
            $request,
            $route->middlewares(),
            $action
        );

    }

}
