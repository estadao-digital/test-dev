<?php
require('DbHandler.php');
// Classe responsável por interagir com a base de dados, executando operações de SELECT, UPDATE, DELETE e INSERT 
class CarrosHandler
{

    private static $instance = null;


    private function __construct()
    { }


    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new CarrosHandler();
        }

        return self::$instance;
    }
    // Função que retorna todos os itens carros da base de dados.
    public function selectCarros()
    {
        try {
            $contentDb =  json_encode(readDb());
            $contentDbJson = json_decode($contentDb);
            $res = new Response(200, "Todos os Carros", $contentDbJson);
        } catch (Exception $exc) {
            $res = new Response($exc->getCode(), $exc->getMessage(), []);
        }

        return $res;
    }
    // Função que retorna um item carro da base de dados que possua o mesmo ID passado por parâmetro.
    public function selectCarroById($carroId)
    {

        try {
            $dbContentObj = readDb();
            $selectedCarro = null;
            $res = new Response(200, "", []);
            foreach ($dbContentObj as $key => $item) {
                if ($carroId == $item->carro_id) {
                    $selectedCarro = $item;
                }
            }
            if (isset($selectedCarro)) {
                $res->setMessage("Carro selecionado com sucesso");
                $res->setData($selectedCarro);
            } else {
                $res->setStatusCode(400);
                $res->setMessage("Carro não encontrado");
            }
        } catch (Exception $exc) {
            
            $res = new Response($exc->getCode(), $exc->getMessage(), []);
        }
        return $res;
    }
    // Função que insete um novo item carro da base de dados.
    public function insertCarro($carro)
    {

        $res = new Response(200, "", []);

        try {
            $this->verifyCarro($carro);
            $dbContentObj = readDb();
            $tmpCarro = json_decode($carro);
            $tmpCarro->carro_id = uniqid("");
            array_push($dbContentObj, $tmpCarro);
            writeDb($dbContentObj);
            $res->setMessage("Carro inserido com sucesso.");
            $res->setData($tmpCarro);
        } catch (Exception $exc) {
            var_dump($exc);
            $res->setStatusCode(400);
            $res->setMessage($exc->getMessage());
        }

        return $res;
    }
    // Função que deleta um item carro da base de dados que possua o mesmo ID passado por parâmetro.
    public function deleteCarro($carroId)
    {
        $res = new Response(200, "", []);
        $fileContentObj = readDb();
        $carroRemovido = null;

        foreach ($fileContentObj as $key => $item) {
            if ($item->carro_id == $carroId) {
                $carroRemovido = $item;
                $res->setData($carroRemovido);
                array_splice($fileContentObj, $key, 1);
            }
        }

        try {
            if ($carroRemovido) {
                writeDb($fileContentObj);
                $res->setData($carroRemovido);
                $res->setMessage("Carro removido com sucesso.");
            } else {
                $res->setMessage("Carro não existe.");
                $res->setStatusCode(400);
            }
        } catch (Exception $exc) {
            $res->setStatusCode(400);
            $res->setMessage($exc->getMessage());
        }
        return $res;
    }
    // Função que atualiza um item carro da base de dados que possua o mesmo ID passado por parâmetro.
    public function updateCarro($carroId, $carro)
    {
        $res = new Response(200, "", []);

        try {
            $this->verifyCarro($carro);

            $carroUpdated = json_decode($carro);
            $fileContentObj = readDb();

            $carroTmp = null;
            foreach ($fileContentObj as $key => $item) {
                if ($item->carro_id == $carroId) {
                    $carroTmp = $item;
                    $carroUpdated->carro_id = $carroTmp->carro_id;
                    $fileContentObj[$key] = $carroUpdated;
                }
            }
            if ($carroTmp) {
                writeDb($fileContentObj);
                $res->setData($carroTmp);
                $res->setMessage("Carro alterado com sucesso.");
            } else {
                $res->setMessage("Carro não existe.");
                $res->setStatusCode(400);
            }
        } catch (Exception $exc) {
            $res->setMessage($exc->getMessage());
            $res->setStatusCode(400);
        }
        return $res;
    }
    // Função que verifica se o parâmetro é um objeto carro valido, e retorna true ou false
    public function verifyCarro($carro)
    {
        $carroAsObj = json_decode($carro, true);
        $isValid = true;
        if (!isset($carroAsObj['carro_modelo']) || $carroAsObj['carro_modelo'] == "") {
            throw new Exception("Modelo invalido ou vazio");
            $isValid = false;
        }
        if (!isset($carroAsObj['carro_marca']) || $carroAsObj['carro_marca'] == "") {
            throw new Exception("Marca invalido ou vazio");
            $isValid = false;
        }
        if (!isset($carroAsObj['carro_ano']) || $carroAsObj['carro_ano'] == "") {
            throw new Exception("Ano invalido ou vazio");
            $isValid = false;
        }

        return $isValid;
    }
}
