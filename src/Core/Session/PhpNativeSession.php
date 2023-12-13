<?php

namespace Src\Core\Session;

use Src\Core\Session\Interfaces\SessionStorage;

class PhpNativeSession implements SessionStorage
{
    public function flash(string $key, mixed $value)
    {
    }

    public function start()
    {
        if(!session_start()) {
            throw new \RuntimeException('Session failed to start');
        }
    }

    public function save()
    {
        session_write_close();
    }

    public function id(): string
    {
        return session_id();
    }

    public function get(string $key, $default = null): string|null|array
    {
        return $_SESSION[$key] ?? $default;
    }

    public function set(string $key, mixed $value): string|array
    {
        return $_SESSION[$key] = $value;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key)
    {
        unset($_SESSION[$key]);
    }

    public function destroy(string $key)
    {
        session_destroy();
    }
}
