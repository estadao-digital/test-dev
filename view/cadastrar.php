<?php
include("../Carro.class.php");
$carro = new Carro();
$marcas = $carro->getMarcas();
//var_dump($marcas);
?>

<div class="mb-20 text-right"><i class="fas fa-reply btn-view c-pointer" data-view="listar"></i></div>

<h2>Cadastrar Carro</h2>

<form id="form" class="d-flex f-direction-column container-form">
    <select name="" id="marca">
        <option value="">Selecione uma marca</option>
        <?php foreach($marcas as $marca): ?>
            <option value="<?= $marca['nome']; ?>" ><?= $marca['nome']; ?></option>
        <?php endforeach; ?>
    </select>
    <input type="text" id="modelo" placeholder="Modelo">
    <input type="text" id="ano" placeholder="Ano">
    <input type="submit" value="Salvar">
</form>