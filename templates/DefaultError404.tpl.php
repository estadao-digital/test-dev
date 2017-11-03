<?php
	$this->assign('title','CADASTRO DE CARROS | File Not Found');
	$this->assign('nav','home');

	$this->display('_Header.tpl.php');
?>

<div class="container">

	<h1>Ops!</h1>

	
	<p>A página que você requisitou não foi encontrada. Verifique se você digitou o URL corretamente.</p>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>