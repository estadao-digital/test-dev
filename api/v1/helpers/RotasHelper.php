<?php
    //array onde guardarei todas as rotas
    $rotas = [];

    //Adiciona uma rota no array. A rota tem uma função de callback, um método e uma url
    function addRota($url, $callback, $metodo){
        global $rotas;
        $temId=false;
        $url = str_replace('/','',$url);
        $url = $url.'_'.$metodo;//adiciona o método ao nome a rota para poder ter urls iguais com métodos diferentes
        if(strpos($url, '{id}')){
            $url = str_replace('{id}', '', $url);
            $url = $url .'_id';
            $temId = true;
        }
        $rotas[$url] = ['callback' => $callback, 'temId' => $temId];
    }
    function get($url, Closure $callback)
    {
        addRota($url, $callback, 'GET');
    }

    function post($url, Closure $callback)
    {
        addRota($url, $callback, 'POST');
    }

    function put($url, Closure $callback)
    {
        addRota($url, $callback, 'PUT');
    }

    function delete($url, Closure $callback)
    {
        addRota($url, $callback, 'DELETE');
    }

    //Chama uma rota pela url passada.
    function dispatch($rota)
    {
        global $rotas;

        $parametros = explode('/', $rota);
        $acao = $parametros[1] .'_'. $_SERVER['REQUEST_METHOD'];
        if(isset($parametros[2])) {
            $acao = $acao.'_id';
            $id   = $parametros[2];
        }
        if (isset($rotas[$acao])) {
            $callback   = $rotas[$acao]['callback'];
            //A função pode ou não ter o ID como parametro
            echo $rotas[$acao]['temId'] ? call_user_func($callback, $id) : call_user_func($callback);
        } else {
            echo 'Método não autorizado';
        }
    }
