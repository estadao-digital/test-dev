<?php
use PHPUnit\Framework\TestCase;
use Model\CarroDAO;
use Model\CarroModel;

class CarroDaoTest extends TestCase
{
  private $arquivoOriginal;
  private $dao;
  private $mock;

  public function testRead ()
  {
    $carros = $this->dao->read();

    $this->assertEquals($carros[0]['id'], 1);
  }

  public function testCreate ()
  {
    $novoCarro = new CarroModel();

    $novoCarro->marca = "GM";
    $novoCarro->modelo = "Onix";
    $novoCarro->ano = "2019";
    $this->dao->create($novoCarro);
    $carros = $this->dao->read();
    $ultimo = count($carros) - 1;
    $carro = $carros[$ultimo];

    //Verificamos se o novo carro foi cadastrado
    $this->assertEquals($carro['modelo'], "Onix");

    //Verificamos se o id de carros foi incrementado
    $this->assertEquals($carros[$ultimo]['id'], $carros[$ultimo-1]['id'] + 1);
  }

  public function testUpdate ()
  {
    //Cria o model com os valores desejados
    $carro = new CarroModel();
    $carro->id = 5;
    $carro->marca = 'Hyundai';
    $carro->modelo = 'HB20';
    $carro->ano = '2015';
    //faz o update do registro
    $this->dao->update($carro);

    //Recupera o registro modificado para o teste
    $carros = $this->dao->read();
    foreach ($carros as $car) {
      if ($car['id'] = $carro->id)
      $carroRecuperado = $car;
    }

    $this->assertEquals($carroRecuperado['id'], $carro->id);
  }

  public function testGet ()
  {
    $carros = $this->dao->read();
    $carro = $this->dao->get($carros[0]['id']);

    $this->assertEquals($carros[0]['id'], $carro['id']);
    $this->assertEquals($carros[0]['marca'], $carro['marca']);
    $this->assertEquals($carros[0]['modelo'], $carro['modelo']);
    $this->assertEquals($carros[0]['ano'], $carro['ano']);
  }

  public function testDelete ()
  {
    //Verifica o total de registros antes de adicionar um novo registro
    $totalRegistros = count($this->dao->read());
    
    //Adiciona o novo registro
    $carro = new CarroModel();
    $carro->marca = 'Hyundai';
    $carro->modelo = 'HB20';
    $carro->ano = '2015';
    $this->dao->create($carro);

    //Pega o novo total para confirmar que houve a gravação
    $carros = $this->dao->read();
    $novoTotal = count($carros);

    //faz uma asserção para conferir a gravação indicando que o teste pode continuar
    $this->assertEquals($totalRegistros, ($novoTotal - 1));

    //apaga o registro criado
    $idRegistroDeletar = $carros[$novoTotal - 1]['id'];
    $this->dao->delete($idRegistroDeletar);

    //recupera dados para teste
    $novoTotal = count($this->dao->read());
    $this->assertEquals ($totalRegistros, $novoTotal);
  }

  public function setUp()
  {
    parent::setUp();
    $this->dao = new CarroDAO();
    $this->mock = __DIR__."/../model/carros_mock.json";
    $fp = fopen($this->mock, 'r');
    $this->arquivoOriginal = fread($fp, filesize($this->mock));
    fclose($fp);
  }

  public function tearDown()
  {
    $fp = fopen($this->mock, 'w');
    fwrite($fp, $this->arquivoOriginal);
    fclose($fp);
    parent::tearDown();
  }
}
