<?php

    $caminhoBanco = '';
    $banco = 'bancoJson';

    //Lê todos os registros do arquivo
    function leTabela(String $tabela)
    {
        return  json_decode(file_get_contents(pegaCaminho($tabela)),TRUE);
    }

    //Salva o conteúdo completo no arquivo
    function salvaTabela(String $tabela, array $registros){
        file_put_contents(pegaCaminho($tabela), json_encode($registros));
        return 'Tabela salva';
    }

    //Adiciona um novo registro no arquivo
    function adicionaRegistro(String $tabela, array $objeto)
    {
        $objetos = leTabela($tabela);
        $objeto = array_merge($objeto,['ID' => pegaUltimoId($objetos)+1]);
        array_push($objetos, $objeto);
        salvaTabela($tabela, $objetos);
        return $objeto['ID'];
    }

    //Faz uma alteração em um registro por ID
    function modificaRegistro(String $tabela, $novoObjeto, int $id){
        $objetos = leTabela($tabela);
        $objetos[encontraRegistro($tabela, $id)['index']] = $novoObjeto;
        return salvaTabela($tabela, $objetos);
    }


    function deletaRegistro(String $tabela, int $id){
        $objetos = leTabela($tabela);
        unset($objetos[encontraRegistro($tabela, $id)['index']]);
        return salvaTabela($tabela, $objetos);
    }

    //Pesquisa um registro no arquivo usando o ID
    function encontraRegistro(String $tabela, int $id){
        $objetos = leTabela($tabela);
        foreach ($objetos as $index => $objeto){
            if ($objeto['ID'] === $id) {
                return ['objeto' => $objeto, 'index' => $index];
            }
        }
        return null;
    }

    //Serve para pegar o caminho do aqruivo json que será nosso banco de dados
    function pegaCaminho(String $tabela):String{
        global $caminhoBanco, $banco;
        return $caminhoBanco.$banco.'/'.$tabela.'.json';
    }

    //Retorna o valor do último ID para criar um novo
    function pegaUltimoId(array $objetos){
        if (count($objetos) === 0) return 0;
        return end ($objetos)['ID'];
    }

    function pegaRegistroPorID(String $tabela, int $id){
        return encontraRegistro($tabela, $id)['objeto'];
    }

