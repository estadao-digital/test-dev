<?php
/**
 * Created by PhpStorm.
 * User: tito
 * Date: 28/10/18
 * Time: 22:34
 */
        $carro = array(
           "13" => array(
                //"ID" => "13",
                "MARCA" => "chevy",
                "MODELO" => "vectra",
                "ANO" => "2008"
            ),
            "12" => array(
                //"ID" => "12",
                "MARCA" => "chevy",
                "MODELO" => "vectra",
                "ANO" => "2008"
            ),
            "11" => array(
                //"ID" => "11",
                "MARCA" => "chevy",
                "MODELO" => "vectra",
                "ANO" => "2009"
            )
        );
        // Tranforma o array $dados em JSON
        $dados_json = json_encode($carro);


        // O parâmetro "a" indica que o arquivo será aberto para escrita
        $fp = fopen("carros.json", "a");

        // Escreve o conteúdo JSON no arquivo
        $escreve = fwrite($fp, $dados_json);

        // Fecha o arquivo
        fclose($fp);