<?php
Class Paginas {	
	
	function paginaPadrao()
	{
		
	}
	function paginaError()
	{
		$data = array();
		
		$data['title'] = "Página não encontrada.";
		$data['url_css'] =  (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/prova/assets/css/';
		$data['url_js'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].'/prova/assets/js/';
		
		$htmlFile = include($_SESSION['dir'].'/includes/Views/header.php');
		$htmlFile .= include($_SESSION['dir'].'/includes/Views/error.php');
		$htmlFile .= include($_SESSION['dir'].'/includes/Views/footer.php');
		return $htmlFile;
	}
	function render($view, $data)
	{
		$htmlFile = include($_SESSION['dir'].'/includes/Views/header.php');
		$htmlFile .= include($_SESSION['dir'].'/includes/Views/'.$view.'.php');
		$htmlFile .= include($_SESSION['dir'].'/includes/Views/footer.php');
		return $htmlFile;
	}
	
}