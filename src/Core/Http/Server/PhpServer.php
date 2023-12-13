<?php

namespace Src\Core\Http\Server;

use Src\Core\Http\Request\Request;
use Src\Core\Http\Response\Response;
use Src\Core\Http\Constants\HttpMetodos;
use Src\Core\Http\Server\Interfaces\Server;

/**
 * PhpServer Class
 *
 * Clase de **Php_Nativo** que implementa la interfaz Server para desacoplar la aplicacion por si se quiere cambiar de servidor
 */
class PhpServer implements Server
{
    /**
     * @inheritDoc
     */
    public function getRequest(): Request
    {
        $json_data = file_get_contents('php://input');
        $data = json_decode($json_data, true);

        return (new Request())
        ->setUri(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
        ->setMetodo(HttpMetodos::from($_SERVER['REQUEST_METHOD']))
        ->setData($data ?? $_POST)
        ->setQuery($_GET)
        ->setCookies($_COOKIE)
        ->setFiles($_FILES)
        ->setHeaders(getallheaders())
        ->setServer($_SERVER);
    }

    /**
     * @inheritDoc
     */
    public function sendResponse(Response $response)
    {
        //*! PHP Content-Type
        /*header is set to text/html by default*/
        header("Content-Type: None");
        header_remove("Content-Type");
        $response->prepare();
        http_response_code($response->status());
        foreach ($response->headers() as $key => $value) {
            header("$key: $value");
        }
        print($response->content());
    }
}
