<?php

namespace Src\Core\Facades;

class Facade
{
    // protected static $instance;
    protected ?string $instance = null;
    private const FACADE = 'facades.';

    public static function getInstance()
    {
        /** @phpstan-ignore-next-line */
        $self = new static();
        if(is_null($self->instance)) {
            return app();
        }
        /** @phpstan-ignore-next-line */
        if(is_string($self->instance)) {
            return new (config(self::FACADE.$self->instance));
        }

    }

    public static function __callStatic($method, $arguments)
    {
        $instance = self::getInstance();
        return call_user_func_array([$instance, $method ], $arguments);
    }

}
