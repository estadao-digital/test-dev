<?php
 /**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
 use PHPUnit_Framework_TestCase as PHPUnit;
 
require_once '..src/carro.class.php';
class CarroTest extends PHPUnit{
              //Função de teste de tipo - Compara tipo da variável Id
              public function testType() {
                $carro = new selectCarros;

                $this->assertInternalType('int', $carro->select('8'));
 }
               
}
?>