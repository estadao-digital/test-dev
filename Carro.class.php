<?php
/**
* Classe do carro
*/

class Carro {

    private $dados;
    private $id;
    private $marca;
    private $modelo;
    private $ano;

    public function __construct(){
        $this->validaSession();
    }
    
    public function setId($id){
        $this->id = $id;
    }

    public function setMarca($marca){
        $this->marca = $marca;
    }

    public function setModelo($modelo){
        $this->modelo = $modelo;
    }

    public function setAno($ano){
        $this->ano = $ano;
    }

    public function getId(){
        return $this->id;
    }

    public function getMarca(){
        return $this->marca;
    }

    public function getModelo(){
        return $this->modelo;
    }

    public function getAno(){
        return $this->ano;
    }

    private function validaSession(){
        if(!isset($_SESSION)){
            session_start();
        }
        if(!isset($_SESSION["carro"])){
           $_SESSION["carro"][0]=
           array("id"=>1,"marca"=>"Chevrolet","modelo"=>"Clio","ano"=>"2017");
        }
    }
    public function listaCarro(){
        $dados = (array) $_SESSION["carro"];
        
        echo json_encode($dados);
    }

    public function incluirCarro(){
        end($_SESSION["carro"]);
        $ultimaChave= key($_SESSION["carro"]);
        $id=$_SESSION["carro"][$ultimaChave]["id"];
        $_SESSION["carro"][]=array("id"=>$id+1,
                            "marca"=>$this->getMarca(),
                            "modelo"=>$this->getModelo(),
                            "ano"=>$this->getAno()
                        );
        echo json_encode($_SESSION["carro"]);                
    }

    public function excluirCarro(){
        $key = array_search($this->id, array_column($_SESSION["carro"],'id'));
		if($key!==false){
		    unset($_SESSION["carro"][$key]);
		    $_SESSION["carro"]=array_values($_SESSION["carro"]);
        }
        echo json_encode($_SESSION["carro"]);                        
    }

    public function editarCarro(){
        $key = array_search($this->id, array_column($_SESSION["carro"],'id'));
		if($key!==false){
		    $_SESSION["carro"][$key]['marca'] =$this->getMarca();
		    $_SESSION["carro"][$key]['modelo']=$this->getModelo();
            $_SESSION["carro"][$key]['ano']=$this->getModelo();
		}
        echo json_encode($_SESSION["carro"]);                
    }
}

?>