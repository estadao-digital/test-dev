<?php
class Carro {
    public $id;
    public $marca;
    public $modelo;
    public $ano;

    public function __construct($id, $marca, $modelo, $ano) {
        $this->id = $id;
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
    }
}
?>
