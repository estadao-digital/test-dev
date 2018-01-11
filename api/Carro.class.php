<?php

/**
 * Classe do carro
 */
class carro
{
    protected function loadDB()
    {
        ####################### Incluo todos os arquivos do Drive de base de dados ##################
        ####################### O Drive utilizado é esse http://morris.github.io/microdb/
        ####################### Uso ele para pequenos trabalhos como esse
        ####################### é muito simples e util para nao ter que reinventar a roda

        foreach (glob("MicroDB/*") as $filename) {
            require $filename;
        }
        $db = new \MicroDB\Database(__DIR__ . '/database'); // inicio a base de dados
        return $db;
    }

    function create($array)
    {
        $db = $this->loadDB(); #instancio a base de dados
        $id = $db->create($array); #Mando o array para ser salvo
        return $id;
    }

    function load($id = null, $key = null)
    {
        $db = $this->loadDB(); #instancio a base de dados
        if($id) { # caso esteja sendo enviado o id pego ele e a chave que foi setada
            $response = $db->load($id, $key);
        }else{ # caso contrario faco a busca pela chave que retorna tudo
            $response = $db->find(function($response) {
                return is_array(@$response['carros']);
            });
        }
        return $response;
    }

    function edit($id, $array)
    {
        $db = $this->loadDB(); #instancio a base de dados
        $response = $db->save($id, $array); # Mando o id e o array para serem salvos
        return $response;
    }

    function delete($id)
    {
        $db = $this->loadDB(); #instancio a base de dados
        $response = $db->delete($id); #Mando o id para ser apagado
        return $response;
    }

}

?>