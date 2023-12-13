<?php

namespace Tests\Src\Source\Http\Server;

use Src\Core\Http\Request\Request;
use Src\Core\Http\Server\Interfaces\Server;

class MockServer implements Server
{
    public function getRequest(): Request
    {
        return new Request();
    }

    public function sendResponse($response)
    {
        return $response;
    }
}
