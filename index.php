<?php 
    // Define o redirecionamento (HTML ou API) <<== Esquema de rotas

    $url = isset($_GET['url']) ? $_GET['url'] : 'home/';
    $url = array_filter(explode('/', $url));

    switch ($url[0]) {
        case 'home':
            include 'home.html';
            break;
            
        case 'carros':
            $method = $_SERVER['REQUEST_METHOD'];
            if ( !empty($url[1]) ) $id = $url[1];

            include 'api.php';

            break;

        default:
            echo 'Pagina nao encontrada';
            break;
    }
