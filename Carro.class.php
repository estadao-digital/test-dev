<?php
/**
* Classe do carro
*/
class Carro {
  
  private $_marcas;
  private $_carros;

  public function __construct() {
    $this->_marcas = array('marca'=>array(
                                          array('id'=>1, 'value'=>'Audi'),
                                          array('id'=>2, 'value'=>'BMW'),
                                          array('id'=>3, 'value'=>'Chevrolet'),
                                          array('id'=>4, 'value'=>'Citroën'),
                                          array('id'=>5, 'value'=>'Fiat'),
                                          array('id'=>6, 'value'=>'Ford'),
                                          array('id'=>7, 'value'=>'Honda'),
                                          array('id'=>8, 'value'=>'Hyundai'),
                                          array('id'=>9, 'value'=>'Mercedes-Benz'),
                                          array('id'=>10, 'value'=>'Peugeot'),
                                          array('id'=>11, 'value'=>'Renault'),
                                          array('id'=>12, 'value'=>'Suzuki'),
                                          array('id'=>13, 'value'=>'Toyota'),
                                          array('id'=>14, 'value'=>'Volkswagen')
                                         ));
    $this->setCarros();
  }

  public function setCarros($carros='') {
    $carrosDefault = array(
                           array(1 ,2, 3, 4, 5, 6, 7, 8, 9, 10, 11),
                           array(
                                 array('marca'=>6,
                                       'modelo'=>'Focus',
                                       'ano'=>2006),
                                 array('marca'=>5,
                                       'modelo'=>'Mobi',
                                       'ano'=>2016),
                                 array('marca'=>6,
                                       'modelo'=>'Escort L',
                                       'ano'=>1984),
                                 array('marca'=>5,
                                       'modelo'=>'Uno',
                                       'ano'=>2000),
                                 array('marca'=>5,
                                       'modelo'=>'Uno',
                                       'ano'=>2000),
                                 array('marca'=>1,
                                       'modelo'=>'Teste 1',
                                       'ano'=>2000),
                                 array('marca'=>2,
                                       'modelo'=>'Teste 2',
                                       'ano'=>2000),
                                 array('marca'=>3,
                                       'modelo'=>'Teste 3',
                                       'ano'=>2000),
                                 array('marca'=>4,
                                       'modelo'=>'Teste 4',
                                       'ano'=>2000),
                                 array('marca'=>7,
                                       'modelo'=>'Teste 5',
                                       'ano'=>2000),
                                 array('marca'=>8,
                                       'modelo'=>'Teste 6',
                                       'ano'=>2000)
                                )
                          );
    $this->_carros = (!empty($carros)) ? $carros : $carrosDefault;
  }

  public function getMarcas() {
    return $this->_marcas;
  }

  public function getCarros() {
    return $this->_carros;
  }

  public function getCarro($id) {
    $search = array_search($id, $this->_carros[0]);
    $key = ($search!==false) ? $search : '';
    return (!empty($key)) ? $this->_carros[1][$key] : 'Não encontrado';
  }

  public function json_unescaped_unicode($matches) {
    $sym = mb_convert_encoding(pack('H*', $matches[1]), 'UTF-8', 'UTF-16');
    return $sym;
  }
}
?>
