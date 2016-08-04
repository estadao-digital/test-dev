<?php
/**
* Classe do carro
*/
class Carro
{
    public $id;
    public $marca;
    public $modelo;
    public $ano;

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    /*
    * Salva o registro
    */
    public function salva()
    {
        $this->criaId();
        $key = 'carro_' . $this->id;
        $_SESSION[$key] = json_encode($this);
        return true;
    }

    /*
    * Lista todos os registros
    */
    public function lista()
    {
        $retorno = array();
        foreach ($_SESSION as $k => $v) {
            if (preg_match('@carro_\d+@is', $k)) {
                $stdCarro = json_decode($v);
                $retorno[] = $this->objectToObject($stdCarro, 'Carro');
            }
        }

        if (count($retorno) == 0) {
            $erro = ['Status' => false, 'message' => 'Nenhnum Carro cadastrado'];
            die(json_encode($erro));
        }

        return $retorno;
    }

    /*
    * Exibe todos os registros
    */
    public function exibe()
    {
        $key = 'carro_' . $this->id;
        if (@$stdCarro = json_decode($_SESSION[$key])) {
            $carro = $this->objectToObject($stdCarro, 'Carro');
            return $carro;
        } else {
            $erro = ['Status' => false, 'message' => 'Carro nao encontrado'];
            die(json_encode($erro));
        }
    }

    /*
    * Atualiza o registro
    */
    public function atualiza($novoCarro)
    {
        // Verifica se foi enviado o id
        if (!$this->id) {
            $erro = ['Status' => false, 'message' => 'Nao foi definido um id de carro para ser atualizado'];
            die(json_encode($erro));
        }

        $key = 'carro_' . $this->id;
        if (@$stdCarro = json_decode($_SESSION[$key])) {
            $carro = $this->objectToObject($stdCarro, 'Carro');
            $novoCarro->id = $carro->id;
            $_SESSION[$key] = json_encode($novoCarro);
            return true;
        } else {
            $erro = ['Status' => false, 'message' => 'Carro nao encontrado'];
            die(json_encode($erro));
        }
    }

    /*
    * Deleta o registro
    */
    public function deleta()
    {
        // Verifica se foi enviado o id
        if (!$this->id) {
            $erro = ['Status' => false, 'message' => 'Nao foi definido um id de carro para ser deletado'];
            die(json_encode($erro));
        }

        // Deleta o carro
        $key = 'carro_' . $this->id;
        if (@$_SESSION[$key]) {
            unset($_SESSION[$key]);
            return true;
        } else {
            $erro = ['Status' => false, 'message' => 'Id do carro nao foi encontrado'];
            die(json_encode($erro));
        }
    }

    /*
    * Cria um id baseado nos registros que já existem na sessão, se não existir nenhum id é 1
    */
    private function criaId()
    {
        $this->id = 1;
        foreach (array_reverse($_SESSION) as $k => $v) {
            if (preg_match('@carro_(\d+)@is', $k, $mat)) {
                $lastid = $mat[1];
                $this->id = $lastid+1;
                break;
            }
        }
        return true;
    }

    /*
    * Codigo generico para transformar o stdclass no objeto Carro
    */
    function objectToObject($instance, $className) {
        return unserialize(sprintf(
            'O:%d:"%s"%s',
            strlen($className),
            $className,
            strstr(strstr(serialize($instance), '"'), ':')
        ));
    }
}
