<?php

namespace Tests\Src\Source\Views;

use Tests\TestCase;
use Src\Core\Views\ViewsEngine;

class ViewsEngineTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testRender()
    {
        $paramUno =  'Nombre';
        $paramDos =  'Test';

        $expected = "
        <html>
            <h1>
                <h1>$paramUno</h1>
                <h1>$paramDos</h1>
            </h1>
        </html>";

        $engine = new ViewsEngine(__DIR__.'/');
        $contenido =  $engine->render('test', ['paramUno' => $paramUno, 'paramDos' => $paramDos], 'layout');
        $this->assertTrue(true);
        //expresion regular para quitar los espacios en blanco
        $contenido = preg_replace('/\s+/', '', $contenido);
        $expected = preg_replace('/\s+/', '', $expected);
        $this->assertEquals($expected, $contenido);
    }


}
