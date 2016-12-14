<?php
//session_start();
include_once 'Carros.class.php';

class TestApi {
    private $conexao;
    private $classeCarro;

    function __construct() {
        $this->classeCarro = new Carro();
        $this->trataMetodo($_SERVER['REQUEST_METHOD']);
	}

    /**
     * Trata os métodos da API
     */
    private function trataMetodo($metodo){
        switch ($metodo) {
            case 'POST':
                # cadastrar novo carro
                $this->mostraJson($this->classeCarro->gravaCarro($_POST));
                break;
            case 'PUT':
                # Atualiza um carro dado certo id
                $id = $_GET["id"];
                if($id){
                    $this->mostraJson($this->classeCarro->atualizaCarro($id,$_POST));
                }
                break;
            case 'DELETE':
                # remove um carro
                $id = $_GET["id"];
                if($id){
                    $this->mostraJson($this->classeCarro->deletaCarro($id));
                }
                break;
            default:
                # Não é um metodo especial, tratar como GET
                $id = $_GET["id"];
                if($id){
                    // tem Id, retorna um carro só
                    $this->mostraJson($this->classeCarro->mostraCarro($id));
                } else {
                    // retorna todos os carros
                    $this->mostraJson($this->classeCarro->listaCarros());
                }
                break;
        }
    }

    /**
     * Saída de dados
     */
    private function mostraJson($dados){
        echo $this->paraJson($dados);
    }

    /**
     * Converte qualquer tipo de dado para JSON
     */
    private function paraJson($valor)
    {
        if (version_compare(PHP_VERSION, '5.4.0') >= 0) {
            $encoded = json_encode($valor, JSON_PRETTY_PRINT);
        } else {
            $encoded = json_encode($valor);
        }
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                return $encoded;
            case JSON_ERROR_UTF8:
                $limpa = $this->converteUTF8($valor);
                return $this->paraJson($limpa);
            default:
                return json_encode(['erro' => 'Erro ao retornar JSON']);
        }
    }

    /**
     * Converte qualquer dado para UTF8
     */
    private function converteUTF8($mixed)
    {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = $this->converteUTF8($value);
            }
        } else if (is_string ($mixed)) {
            return utf8_encode($mixed);
        }
        return $mixed;
    }
}

$instanciaApi = new TestApi();
?>
