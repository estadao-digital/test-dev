<?php
class CarroDTO extends JsonDatabase
{

    // constructor with $db as database connection
    public function __construct(){
        parent::__construct();
        $this->tabela = "carros";
    }

    public function setCarro($carro) {
        $this->carroEntity = $carro;
    }

    public function setMarcaDTO(MarcaDTO $marcaDTO) {

    }

    public function getMappedData() {
        $carros = $this->getData();
        $resultado = array();

        foreach($carros as $key => $carro) {
            $resultado[$key] = $carro;
            $marca = $this->getDataById($carro['marca'],'marcas');
            $resultado[$key]['marcaNome'] = $marca['nome'];
        }

        return $resultado;
    }

    public function add() {
        $array = array(
            'marca'     => $this->carroEntity->getMarca(),
            'modelo'    => $this->carroEntity->getModelo(),
            'ano'       => $this->carroEntity->getAno()
        );
        return $this->create($array);
    }


}
?>