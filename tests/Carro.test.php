<?php

use PHPUnit\Framework\TestCase;

include(__DIR__ . "/../server/Response.class.php");
include(__DIR__ . "/../server/CarrosHandler.class.php");


class CarroTest extends TestCase
{
    // Testando o objeto Response
    public function testResponse()
    {
        $resp = new Response(200, "", []);
        $this->assertEquals(200, $resp->getStatusCode());
    }
    // Testando o CarrosHandler, se a consulta de carros retornará com sucesso
    public function testCarrosHandlerSelectCarros()
    {
        $res = CarrosHandler::getInstance()->selectCarros();
        $this->assertEquals(200, $res->getStatusCode());
    }
    // Testando o CarrosHandler, se a consulta de carro por id retornará com sucesso
    public function testCarrosHandlerSelectCarroById()
    {
        $res = CarrosHandler::getInstance()->selectCarroById("");
        $this->assertEquals(400, $res->getStatusCode());
    }

    // Testando se a leitura da base de dados esta ok
    public function testReadDB()
    {
        $this->assertEquals(true, is_array(readDb()));
    }
}
