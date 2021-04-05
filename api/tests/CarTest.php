<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\JsonResponse;

class CarTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testIndexJson()
    {
        $response = $this->call('GET', '/carros');

        $this->assertEquals(200, $response->status()); // VERIFICA O ESTATUS DA PÁGINA
    }

    public function testCreateJson()
    {
        $car = ['marca' => 'FIAT', 'modelo' => 'PALIO', 'ano' => '2011'];

        $response = $this->json('POST', '/carros', $car);

        $response->seeJson($car); // COMPARA SE O RESULTADO DO POST É O MESMO DA INSERÇÃO

    }

    public function testShowJson()
    {

        $response = $this->json('GET', '/carros'); // PEGA JSON

        $array = json_decode($this->response->getContent(), true); // PREPARA DADOS

       // dd(array_shift($array));
        $this->json('GET', '/carros', ['id' => array_shift($array)['id']]) // PEGA O PRIMEIRO ELEMENTO - ID
            ->seeJson(['marca' => array_shift($array)['marca']]); // COMPARA A MARCA - DO RESULTADO, ** PODE SER COMPARADO ID, MARCA,ETC..
    }

    public function testUpdateJson()
    {
        $car = ['marca' => 'FIAT', 'modelo' => 'PALIO', 'ano' => '2021'];

        $response = $this->json('GET', '/carros'); // PEGA JSON

        $array = json_decode($this->response->getContent(), true); // PREPARA DADOS

        $id = array_pop($array)['id']; // PEGA ULTIMO ID - COMO ESTAMOS ADICIONANDO NO MÉTODO testCreateJson(), AQUI ATUALIZAMOS

        $this->json('PUT', '/carros/'.$id, $car)
          ->assertEquals(200, $this->response->status()); // VERIFICA O ESTATUS DA PÁGINA

    }

    public function testDestroyJson()
    {
        $response = $this->json('GET', '/carros'); // PEGA JSON
        $array = json_decode($this->response->getContent(), true); // PREPARA DADOS
        // $id = array_shift($array)['id']; // PEGA PRIMEIRO ID
        $id = array_pop($array)['id']; // PEGA ULTIMO ID - PREFIRO ESSA MANEIRO, COMO ESTAMOS ADICIONANDO NO MÉTODO testCreateJson(), AQUI DELETAMOS

        $response = $this->call('DELETE', '/carros/'.$id);
        $this->assertEquals(200, $response->status()); // VERIFICA O ESTATUS DA PÁGINA

        $this->assertEquals('"Carro removido com sucesso!!!"', $this->response->getContent()); // Test de string do response

        /// EXEMPLE MANUAL
        // $response = $this->call('DELETE', '/carros/4');
        // $this->assertEquals(200, $response->status());
    }
}
