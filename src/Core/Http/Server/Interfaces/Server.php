<?php

namespace Src\Core\Http\Server\Interfaces;

use Src\Core\Http\Response\Response;
use Src\Core\Http\Constants\HttpMetodos;
use Src\Core\Http\Request\Request;

/**
 * Interface Server
 *
 * Interface que se usa en  el constructor de **Request::class**
 * y que se implementa en **PhpServer::class** para desacoplar la aplicacion por si se quiere cambiar de servidor
 */
interface Server
{
    /**
     * Get Request
     * @return Request
     * Devuelve la instancia de la clase **Request::class** con los datos de la peticion
     * formateados en la clase **Request::class**
     */
    public function getRequest(): Request;

    /**
     * Send Response
     * @param  Response $response->content()
     * @return void
     * Envia la respuesta al cliente con los datos de la respuesta
     * previamente formateados en formato **json|text** en el response.
     */
    public function sendResponse(Response $response);
}
