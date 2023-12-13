<?php

namespace Src\Core\Providers;

use Src\Core\Session\PhpNativeSession;
use Src\Core\Session\Interfaces\SessionStorage;
use Src\Core\Providers\Interfaces\ServiceProviderInterface;

class SessionServiceProvider implements ServiceProviderInterface
{
    public function register()
    {
        /** @phpstan-ignore-next-line */
        match (config('app.session_storage')) {
            'native' => singleton(SessionStorage::class, PhpNativeSession::class),
        };
    }
}
