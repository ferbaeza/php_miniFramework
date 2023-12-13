<?php

namespace Src\Core\Http\Response;

/**
 * ApiResponse
 *
 * Clase que extiende de Response para crear una de la Api
 * en formato json pasandole un array de datos y un codigo de estado
 *
 */
class ApiResponse extends Response
{
    public const ESTADO_200_OK = 200;
    public const ESTADO_400_ERROR = 400;
    public const ESTADO_401_NO_AUTORIZADO = 401;
    public const ESTADO_404_RECURSO_NO_ENCONTRADO = 404;

    public const RESPONSE = ['response' => 'Api Response'];

    /**
     * Undocumented function
     * @param  array $data
     * @param  int $statusCode
     * @param  ?string $header
     * @return Response
     */
    public static function json(array $data = [], int $statusCode = null, ?string $header = null): Response
    {
        $data = (empty($data) || in_array(null, $data)) ? self::RESPONSE : $data;
        $statusCode = $statusCode ?? self::ESTADO_200_OK;
        return parent::jsonResponse($data, $statusCode, $header);
    }


}
