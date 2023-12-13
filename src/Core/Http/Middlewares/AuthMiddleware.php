<?php

namespace Src\Core\Http\Middlewares;

use Closure;
use Src\Core\Config\Config;
use Src\Core\Http\Request\Request;
use Src\Core\Http\Response\Response;
use Src\Core\Http\Response\ApiResponse;
use Src\Core\Http\Middlewares\Interfaces\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @inheritDoc
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!is_null($request->headers('TestHeader')) && !empty($request->headers('TestHeader'))) {
            if($request->headers('TestHeader') != Config::get('app.token')) {
                return ApiResponse::json(['message' => 'Unauthorized'], 401);
            }
            return  $next($request);
        }
        return ApiResponse::json(['message' => 'Unauthorized'], 401);
    }
}
