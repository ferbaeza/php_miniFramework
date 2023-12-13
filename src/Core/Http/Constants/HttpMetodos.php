<?php

namespace Src\Core\Http\Constants;

enum HttpMetodos: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
}
