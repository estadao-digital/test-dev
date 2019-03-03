<?php
/**
* Classe do carro
*/
class Carro {
    public $id;
    public $marca;
    public $modelo;
    public $ano;

    function localizaPorID($vetor, $id){
        $encontrado = -1;
        foreach($vetor as $key => $obj){
            if($obj['id'] == $id){
                $encontrado = $key;
                break;
            }
        }
        return $encontrado;
    }

    public function getCarros($data, $contents, $param){
        if($data){
            if($param == ''){
                echo $contents;
            }else{
                $encontrado = self::localizaPorID($data, $param);
                if($encontrado >= 0){
                    echo json_encode($data[$encontrado]);
                }else{
                    echo 'Error: Id não localizado';
                }
            }
        }else{
            echo '[]';
        }
    }

    public function createCarro($data, $json, $body){
        $jsonBody = json_decode($body, true);
        
        $jsonBody['id'] = time();
        
        if(!$data){
            $data = [];
        }
        
        $data[] = $jsonBody;
        echo json_encode($jsonBody);
        $json["carros"] = $data;
        file_put_contents('carros.json', json_encode($json));
    }

    public function saveCarro($data, $json, $body, $param){
        if($data){
            if($param == ''){
                echo "Error: Código não informado";
            }else{
                $encontrado = self::localizaPorID($data, $param);

                if($encontrado >= 0){
                    $jsonBody = json_decode($body, true);
                    $jsonBody['id'] = $param;
                    $data[$encontrado] = $jsonBody;
                    echo json_encode($data[$encontrado]);
                    $json["carros"] = $data;
                    file_put_contents('carros.json', json_encode($json));
                }else{
                    echo 'Error: Id não localizado';
                    exit;
                }
            }
        }else{
            echo 'Error data';
        }
    }

    public function removeCarro($data, $json, $param){
        if($data){
            if($param == ''){
                echo "Error: Parametro nao localizado";
            }else{
                $encontrado = self::localizaPorID($data, $param);
                if($encontrado >= 0){
                    echo json_encode($data[$encontrado]);
                    unset($data[$encontrado]);
                    $json["carros"] = $data;
                    file_put_contents('carros.json', json_encode($json));
                }else{
                    echo 'Error: Id não localizado';
                    exit;
                }
            }
        }else{
            echo 'Error: Dados não encontrados';
        }
    }
}
?>