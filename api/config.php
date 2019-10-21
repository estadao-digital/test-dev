<?php

    session_start();
    date_default_timezone_set('America/Sao_Paulo');

    define('TOKEN_CLIENT','3DFTaNupO5WSV142LxeiXgcZfOmWazto5pqN46rcNrsbCaRQrAt1BtD2xJyrIJkn');

    //INCLUINDO AS CLASSES EM TODAS AS PÁGINAS
    $autoload = function($class) {
        include('classes/'.$class.'.php');
    };
    spl_autoload_register($autoload);

    //DEFINIÇÃO DAS CONSTANTES DE DIRETÓRIO
    define('INCLUDE_PATH','http://localhost/test-dev/');

    //DEFINIÇÃO DOS DADOS DE ACESSO PARA O BANCO DE DADOS
    define('HOST','localhost');
    define('USER','root');
    define('PASSWORD','');
    define('DATABASE','bd_test-dev');


    function loadPage() {
		if(isset($_GET['url'])) {
			$url = explode('/',$_GET['url']);
			if(file_exists($url[0].'.php')) {
				include ($url[0].'.php');
			}else {
				//SE A PÁGINA NÃO EXISTIR
                echo 'Página não existe';
                die();
			}
		}else {
			include('api/404.php');
		}
    }

?>