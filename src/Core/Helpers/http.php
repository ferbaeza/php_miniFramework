<?php

use Src\Core\Http\Response\Response;

/**
 * json es un helper para retornar una respuesta json
 * @param  array $data
 * @return Response
 */
function json(array $data): Response
{
    return Response::jsonResponse($data);
}

/**
 * redirect es un helper para retornar una respuesta de redireccion
 * @param  string $uri
 * @return Response
 */
function redirect(string $uri): Response
{
    return Response::redirect($uri);
}

/**
 * view es un helper para retornar una respuesta de vista
 * @param  string $view
 * @param  array|null  $params
 * @param  string|null $layout
 * @return Response
 */
function view(string $view, array $params = null, string $layout = null): Response
{
    return Response::view($view, $params, $layout);
}
