<?php

	/**
	
	Prova Slice TI
	Nome: Flávio Módolo Júnior
	Skype: flavio.m6
	Whats / Phone: +55 15 99107 4519
	
	*/
	
	// Iniciando Sessão.
	session_start();
	// Definindo Diretórios
	$base_dir = __DIR__;
	$_SESSION['dir'] = $base_dir;
	
	// Incluindo Models.
	include($base_dir.'/includes/Models/Carros.php');
	include($base_dir.'/includes/Models/Marcas.php');
	
	// Incluindo Controllers.
	include($base_dir.'/includes/Controller/Carros.php');
	include($base_dir.'/includes/Controller/Paginas.php');
	
	
	// Definindo as Rotas

	$rota = array();

	$rota['default'] = 'Carros_Controller/listar';
	$rota['carros'] = 'Carros_Controller/listar';
	$rota['carros/ajax-lista-marcas'] = 'Carros_Controller/ajaxListaMarcas';
	$rota['carros/ajax-salvar'] = 'Carros_Controller/ajaxSalvarItem';
	$rota['carros/ajax-criar-item'] = 'Carros_Controller/ajaxCriarItem';
	$rota['carros/ajax-excluir-item'] = 'Carros_Controller/ajaxExcluirItem';
	$rota['error'] = 'Paginas/paginaError';
	
	// Recolhendo informações da URL
	
	$url_current = $_SERVER['REQUEST_URI'];
	$url_items = explode('/', $url_current);
	if(strpos('prova', $url_items[1]) === false)
	{
		echo "Você esta em uma subfolder. Para esse sistema funcionar corretamente você precisa mover a pasta com seus arquivos para um subfolder do dominio raiz. Ex (dominio.com/prova)";
	}
	else
	{
		// Se a pagina for a inicial.
		if($url_current == '/prova/')
		{
			$default = explode('/', $rota['default']);
			$controller = new $default[0]();
			echo $controller->$default[1]();
		}
		else
		{
			// Removendo a string /prova/ da url para comparar com as rotas.
			$url_current = str_replace('/prova/','',$url_current);
			
			// Então tente encontrar algo compatível.
			if(isset($rota[$url_current]))
			{
				$redirect = explode('/', $rota[$url_current]);
				$controller = new $redirect[0]();
				echo $controller->$redirect[1]();
			}
			else
			{
				// Não é compatível. Então force uma analise mais profunda.
				foreach($rota as $key => $val)
				{
					// Transformando tudo em array para comparações efetivas.
					$keyi = explode('/',$key);
					$vali = explode('/',$val);
					$uri = explode('/',$url_current);
					
					// Definindo pagina de erro como verdadeira por enquanto. ;)
					$error = true;
					
					
					// Variável que vai armazenar dados sobre a rota.
					$validation = array();
					
					// Se a quantidade de items dentro das arrays forem iguais e a key da rota terminar com ':num'.
					if(count($keyi) == count($uri) && end($keyi) == ':num')
					{
						// Comparando segmentação por segmentação da URL.
						$limiter = count($uri);
						for($i=0;$i<=$limiter;$i++)
						{
							// Verificando as ultimas chaves.
							if($keyi[$i] == ':num' && is_numeric($uri[$i]))
							{
								$validation[$i] = 'true';
								if(array_search('false', $validation) == false)
								{
									$url_set = str_replace('/'.end($uri),'',$url_current);
									
									$redirect = explode('/', $rota[$url_set]);
									$controller = new $redirect[0]();
									echo $controller->$redirect[1]();
								}								
							}
							else if($keyi[$i] == $uri[$i])
							{
								$validation[$i] = 'true';
							}
							else
							{
								$validation[$i] = 'false';
							}
						}
					}
				}
				if($error == true)
				{
					$error = explode('/', $rota['error']);
					$controller = new $error[0]();
					echo $controller->$error[1]();
				}				
			}
		}	
	}
	function sortById($a, $b)
	{
		$a = $a['id'];
		$b = $b['id'];

		if ($a == $b) return 0;
		return ($a < $b) ? -1 : 1;
	}