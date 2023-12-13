<?php

namespace Src\Core\Http\Middlewares;

use Closure;
use Src\Core\Http\Request\Request;
use Src\Core\Http\Response\Response;
use Src\Core\Http\Middlewares\Interfaces\MiddlewareInterface;

class TestMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = config('app.token');
        $request->setHeaders([strtolower('TestHeader') => $token]);

        $response = $next($request);
        $response->setHeader('TestHeader', $token);
        return $response;
    }
}
