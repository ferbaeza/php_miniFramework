<?php

namespace Src\Core\Providers;

use Src\Core\Http\Server\PhpServer;
use Src\Core\Http\Server\Interfaces\Server;
use Src\Core\Providers\Interfaces\ServiceProviderInterface;

class ServerServiceProvider implements ServiceProviderInterface
{
    public function register()
    {
        singleton(Server::class, PhpServer::class);
    }

}
