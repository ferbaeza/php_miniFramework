<?php

namespace Src\Core\Providers;

use Src\Core\Database\Drivers\PdoDriver;
use Src\Core\Database\Interfaces\DatabaseDriver;
use Src\Core\Providers\Interfaces\ServiceProviderInterface;

class DatabaseServiceProvider implements ServiceProviderInterface
{
    public function register()
    {
        /** @phpstan-ignore-next-line */
        match (config('database.default')) {
            'mysql', 'pgsql' => singleton(DatabaseDriver::class, PdoDriver::class),
        };
    }
}
