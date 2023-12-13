<?php

namespace Tests\Src\Source\Http\Request;

use PHPUnit\Framework\TestCase;
use Src\Core\Http\Constants\HttpMetodos;
use Src\Core\Http\Request\Request;

/**
 * @group http
 * @group request
 */
class RequestTest extends TestCase
{
    /** @test*/
    public function test_request_devuelve_data_desde_server()
    {
        $uri = '/api';
        $queryData = ['id' => 1];
        $postData = ['name' => 'Fer'];
        $request =  (new Request())->setUri($uri)
            ->setMetodo(HttpMetodos::POST)
            ->setQuery($queryData)
            ->setData($postData);

        $this->assertEquals($request->uri(), $uri);
        $this->assertEquals($request->metodo(), HttpMetodos::POST);
        $this->assertEquals($request->query(), $queryData);
        $this->assertEquals($request->data(), $postData);
    }

    public function test_que_devuelve_el_valor_del_body_si_se_le_pasa_la_clave()
    {
        $data = ['name' => 'Fer', 'id' => 1, 'email' => '@mail.com'];
        $request = (new Request())->setData($data);

        $this->assertEquals($request->data('name'), $data['name']);
        $this->assertEquals($request->data('id'), $data['id']);
        $this->assertEquals($request->data('email'), $data['email']);
    }

    public function test_que_devuelve_el_valor_de_la_query_si_se_le_pasa_la_clave()
    {
        $data = ['name' => 'Fer', 'id' => 1, 'email' => '@mail.com'];
        $request = (new Request())->setQuery($data)->setData($data);

        $this->assertEquals($request->query('name'), $data['name']);
        $this->assertEquals($request->query('id'), $data['id']);
        $this->assertEquals($request->query('email'), $data['email']);
    }
}
