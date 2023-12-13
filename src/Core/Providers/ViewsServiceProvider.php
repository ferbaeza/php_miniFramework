<?php

namespace Src\Core\Providers;

use Src\Core\Views\ViewsEngine;
use Src\Core\Views\Interfaces\ViewInterface;
use Src\Core\Providers\Interfaces\ServiceProviderInterface;

class ViewsServiceProvider implements ServiceProviderInterface
{
    public function register()
    {
        /** @phpstan-ignore-next-line */
        match (config('app.view_engine')) {
            'default' => singleton(ViewInterface::class, fn () => new ViewsEngine(resourcesViews())),
        };
    }
}
