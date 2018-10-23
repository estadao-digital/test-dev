<?php
class MarcaDTO extends JsonDatabase
{

    // constructor with $db as database connection
    public function __construct(){
        parent::__construct();
        $this->tabela = "marcas";
    }

    public function setCarro($carro) {
        $this->carroEntity = $carro;
    }

}
?>