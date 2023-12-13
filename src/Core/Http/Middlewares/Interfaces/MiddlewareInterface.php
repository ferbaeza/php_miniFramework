<?php

namespace Src\Core\Http\Middlewares\Interfaces;

use Closure;
use Src\Core\Http\Request\Request;
use Src\Core\Http\Response\Response;

interface MiddlewareInterface
{
    /**
     * Handle an incoming request.
     * @param  Request  $request
     * @param  Closure  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response;
}
