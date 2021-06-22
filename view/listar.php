<?php
include("../Carro.class.php");
$carro = new Carro();
$items = $carro->getAllCarros();
//var_dump($items);
?>

<div class="mb-10 d-flex j-content-flex-end"><button class="btn btn-view" data-view="cadastrar">Adicionar carro</button></div>

<?php foreach($items as $item): ?>
    <div class="line-carro d-flex j-content-space-between" id="car-<?= $item['id']; ?>">
        <div>id: <?= $item['id']; ?> - <?= $item['marca'] ?> - <?= $item['modelo'] ?> - <?= $item['ano'] ?></div>
        <div>
            <i class="fas fa-pen c-pointer btn-view" data-view="editar" data-id="<?= $item['id']; ?>"></i> 
            <i class="fas fa-trash-alt btn-delete c-pointer" data-id="<?= $item['id']; ?>"></i>
        </div>
    </div>
<?php endforeach; ?>