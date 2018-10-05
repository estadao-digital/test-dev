<?php
namespace Model;

use Model\CarroModel;

/**
 * Classe manipula a o CRUD de carros no arquivo csv
 */
class CarroDAO
{
  private $mock;

  public function __construct()
  {
    $this->mock = __DIR__."/carros_mock.json";
  }

  /**
   * Lê os dados no arquivo cvs e os retorna como um array associativo
   */
  public function read ()
  {
    $fp = fopen($this->mock, 'r');
    $conteudo = fread($fp, filesize($this->mock));
    fclose($fp);
    return json_decode($conteudo, true);
  }

  /**
   * Cria um novo registro e grava no arquivo CSV
   */
  public function create (CarroModel $carroObj)
  {
    //Converte o objeto carro em um array associativo
    $carro = $this->toArray($carroObj);

    $carros = $this->read();
    $carro['id'] = $this->createId($carros);
    $carros[] = $carro;

    $this->saveFile ($carros);
    return $carro;
  }

  /**
   * Altera um registro no arquivo CSV
   * $carroObj deve obrigatoriamente conter um id válido no conjunto de dados
   */
  public function update (CarroModel $carroObj)
  {
    $novoCarro = $this->toArray($carroObj);
    $carros = $this->read();
    foreach ($carros as $key => $carro) {
      if($carro['id'] == $novoCarro['id']) {
        $carros[$key]['id'] = $novoCarro['id'];
        $carros[$key]['marca'] = $novoCarro['marca'];
        $carros[$key]['modelo'] = $novoCarro['modelo'];
        $carros[$key]['ano'] = $novoCarro['ano'];
        break;
      }
    }
    $this->saveFile ($carros);
    return $carros;
  }

  /**
   * Recupera um registro específico pelo id
   */
  public function get($id)
  {
    $carros = $this->read();
    foreach ($carros as $key => $carro) {
      if ($carro['id'] == $id)
        return ($carros[$key]);
    }
  }

  /**
   * Deleta um registro do arquivo CSV
   */
  public function delete ($id)
  {
    $posicaoRemover = 0;
    $carros = $this->read();
    foreach ($carros as $key => $carro) {
      if ($carro['id'] == $id) {
        unset($carros[$key]);
        $this->saveFile($carros);
        break;
      }
    }
  }

  /**
   * Pega o id do último registro e incrementa em uma unidade
   */
  private function createId ($carros)
  {
    $ultimo = count($carros) - 1;
    $novoId = (int)$carros[$ultimo]['id'] + 1;
    return $novoId;
  }

  /**
   * Transforma um objeto em array associativo, necessário para transformar CarroModel e array
   * e podermos manipula-lo nas funções da classe CarroDAO
   */
  private function toArray ($obj)
  {
    $array = [];
    foreach ($obj as $key => $val) {
      $array[$key] = $val;
    }

    return $array;
  }

  /**
   * Sava o array associativo no arquivo csv no formato json
   */
  private function saveFile ($carros)
  {
    $fp = fopen($this->mock, 'w');
    fwrite($fp, json_encode($carros));
    fclose($fp);
  }
}