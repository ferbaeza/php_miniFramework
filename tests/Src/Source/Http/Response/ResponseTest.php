<?php

namespace Tests\Src\Source\Http\Response;

use PHPUnit\Framework\TestCase;
use Src\Core\Http\Response\Response;

/**
 * @group http
 * @group response
 */
class ResponseTest extends TestCase
{
    public function testJsonResponse()
    {
        $data = ['response' => 'Hello Fer'];
        $statusCode = 200;
        $header = 'application/json';

        $response = Response::jsonResponse($data, $statusCode, $header);


        $dataJson = [
            'data' => $data,
            'status' => $statusCode,
        ];
        $this->assertTrue($response instanceof Response);

        $this->assertEquals($response->content(), json_encode($dataJson));
        $this->assertEquals($response->status(), $statusCode);
        $this->assertEquals($response->headers(), ['content-type' => $header]);
    }

    public function testTextResponse()
    {
        $data = 'Hello World';
        $status = 200;
        $response = Response::text($data, $status);

        $this->assertTrue($response instanceof Response);

        $this->assertEquals($response->content(), $data);
        $this->assertEquals($response->status(), $status);
    }

}
