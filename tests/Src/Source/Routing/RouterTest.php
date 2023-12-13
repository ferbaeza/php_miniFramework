<?php

namespace Tests\Src\Source\Routing;

use Closure;
use Tests\TestCase;
use Src\Core\Routing\Router;
use Src\Core\Http\Request\Request;
use Src\Core\Http\Response\Response;
use Src\Core\Http\Constants\HttpMetodos;

/**
 * @group route
 */
class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_resolve_basic_route()
    {
        $uri = "/home";
        $accion = fn () => 'test';
        $router = new Router();
        $router->get($uri, $accion);
        $request = (new Request())->setUri($uri)->setMetodo(HttpMetodos::GET);
        $route = $router->resolveRoute($request);

        $this->assertEquals($route->action(), $accion);
        $this->assertEquals($route->uri(), $uri);
    }

    private function createMockRequest(string $uri, HttpMetodos $metodo): Request
    {
        return (new Request())->setUri($uri)->setMetodo($metodo);
    }

    public function test_resolve_basic_route_usando_el_mock_de_phpUnit()
    {
        $uri = "/home";
        $accion = fn () => 'test';
        $router = new Router();
        $router->get($uri, $accion);
        $route = $router->resolveRoute($this->createMockRequest($uri, HttpMetodos::GET));

        $this->assertEquals($route->action(), $accion);
        $this->assertEquals($route->uri(), $uri);
    }

    public function test_m()
    {
        $router = new Router();
        $midd = new class () {
            public function handle(Request $request, Closure $next): Response
            {
                $response = $next($request);
                $response->setHeader('XX-Test-Header', 'TestMiddleware');
                return $response;
            }
        };
        $uri = "/home";
        $expected = Response::text('test', 200);
        $router->get($uri, fn () => $expected)->setMiddleware([$midd]);
        $response = $router->resolve($this->createMockRequest($uri, HttpMetodos::GET));

        $this->assertEquals($response->headers('XX-Test-Header'), 'TestMiddleware');
        $this->assertEquals($response, $expected);
    }
}
