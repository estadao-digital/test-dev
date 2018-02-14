<?php
/**
* Classe do carro
*/
class Carro{

    private $id;
    private $newId;
    private $marca;
    private $modelo;
    private $ano;
    public $carros;
    public $preparado = false;

    function Carro($data = false){
        $this->carros = file_get_contents('carros.json');
        $this->carros = json_decode($this->carros, true);
        $this->newId = md5(microtime(true));

        if($data){
            $this->prepare($data);
            $this->create();
        }
    }

    //metodo que adiciona um carro
    function create($data = false){
        if($data){
            $this->prepare($data);
        }
        //salva o novo documento
        if(!$this->preparado){ return false; }

        $novCarroArray = [ 
            "id" => $this->newId ,
            "marca" => $this->marca ,
            "modelo" => $this->modelo ,
            "ano"=> $this->ano
        ];
        array_push($this->carros, $novCarroArray);
        $this->upJson();
        return json_encode($novCarroArray);
    }

    //metodo que atualiza um carro pelo id
    function update($id = false, $data = false){
        
        //seta os dados para serem atualizados
        if($data){
            $this->prepare($data);
        }

        //se o id e os dados para atualização não estiverem devidamenteo preparados retorna um booleano false
        if( !$id || !$this->preparado || !isset($id["id"]) ){ return false; }
        $this->setId($id["id"]);
        $carro = array_filter($this->carros, function($data){
            
            return $data["id"] === $this->getId();
        });

        if(!$carro){ $this->create(); return false; }
        //retorna o chave do array a ser atualizado
        $keyCarro = array_keys($carro)[0];

        //atualiza os dados
        $this->carros[$keyCarro]["marca"] = $this->marca;
        $this->carros[$keyCarro]["modelo"] = $this->modelo;
        $this->carros[$keyCarro]["ano"] = $this->ano;
        $this->carros;
        //metodo que finaliza os dados no arquivo carro.json
        $this->upJson();
        return json_encode($this->carros[$keyCarro]);
    }

    //metodo que deleta um carro pelo id
    function delete($id = false){
        if($id && isset($id["id"])){
            $this->setId($id["id"]);
            $carro = array_filter($this->carros, function($data){
                return $data["id"] === $this->getId();            
            });
            if(!$carro){ return false; }
            $keyCarro = array_keys($carro)[0];
            unset($this->carros[$keyCarro]);
            $this->carros = array_values($this->carros);
            $this->upJson();
    }
    return json_encode($this->carros);
    }
    
    //metodo que retorna todos os carros ou apenas um com o id informado
    function retrieve($id = false){
        if($id && isset($id['id'])){
            $this->setId($id['id']);
            $data = array_filter($this->carros, function($data){
                return $data["id"] === $this->getId();
        });
        if(!$data){ return false; }
            $keyCarro = array_keys($data)[0];
            return json_encode($data[$keyCarro]);
    }
    return json_encode($this->carros);
        
    }

    function prepare($data){
        /**ID, Marca, Modelo, Ano. */
        if(isset($data)){
            $this->setMarca($data["marca"]);
            $this->setModelo($data["modelo"]);
            $this->setAno($data["ano"]);
            return $this->setPreparado(true);
        }
        return false;
    }

    function upJson(){
        file_put_contents("carros.json", json_encode($this->carros));
    }
    // geters e seters
    function setId($id){
        $this->id = $id;
    }
    function getId(){
        return $this->id;
    }
    function getNewId(){
        return $this->newId;
    }

    function setPreparado($preparado){
        $this->preparado = $preparado;
    }

    function getPreparado(){
        return $this->preparado;
    }

    function getMarca(){
        return $this->marca;
    }
    
    function setMarca($marca){
        $this->marca = $marca;
    }
    function getModelo(){
        return $this->modelo;
    }
    function setModelo($modelo){
        $this->modelo = $modelo;
    }
    function getAno(){
        return $this->ano;
    }
    function setAno($ano){
        $this->ano = $ano;
    }
 

}
