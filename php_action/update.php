<?php
// Sessão
session_start();
// Conexão
require_once 'db_connect.php';

if(isset($_POST['btn-editar'])):
	$marca = mysqli_escape_string($connect, $_POST['marca']);
	$modelo = mysqli_escape_string($connect, $_POST['modelo']);
	$ano = mysqli_escape_string($connect, $_POST['ano']);

	$id = mysqli_escape_string($connect, $_POST['id']);

	$sql = "UPDATE carros SET marca = '$marca', modelo = '$modelo', ano = '$ano' WHERE id = '$id'";

	if(mysqli_query($connect, $sql)):
		$_SESSION['mensagem'] = "Atualizado com sucesso!";
		header('Location: ../index.php');
	else:
		$_SESSION['mensagem'] = "Erro ao atualizar";
		header('Location: ../index.php');
	endif;
endif;