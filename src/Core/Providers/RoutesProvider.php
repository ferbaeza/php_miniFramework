<?php

namespace Src\Core\Providers;

use Src\Core\App;
use Src\Core\Routing\Route;
use Src\Core\Providers\Interfaces\RoutesProviderInterface;

class RoutesProvider implements RoutesProviderInterface
{
    public static function load()
    {
        $routesPath = App::$rootDirectory . config("app.routes_folder");
        Route::loadRoutes($routesPath);
    }
}
