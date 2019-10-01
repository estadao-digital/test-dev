<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Cadastrar Carro</h2>
    </div>
        <div class="p-2">
            <?= $this->Html->link(__('Listar carros'), ['controller' => 'carros', 'action' => 'index'], ['class' => 'btn btn-outline-info btn-sm']) ?>
        </div>
</div><hr>
<?= $this->Flash->render() ?>

<?= $this->Form->create($carro) ?>
<div class="form-row">
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Marca</label>
        <?= $this->Form->control('marca', ['class' => 'form-control', 'placeholder' => 'Digite a marca do seu carro', 'label' => false]) ?>
    </div>
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Modelo</label>
        <?= $this->Form->control('modelo', ['class' => 'form-control', 'placeholder' => 'Modelo do seu carro', 'label' => false]) ?>
    </div>
    <div class="form-group col-md-6">
        <label><span class="text-danger">*</span> Ano</label>
        <?= $this->Form->control('ano', ['class' => 'form-control', 'placeholder' => 'Ano do seu carro', 'label' => false]) ?>
    </div>
</div>

<p>
    <span class="text-danger">* </span>Campo obrigatório
</p>
<?= $this->Form->button(__('Cadastrar'), ['class' => 'btn btn-success']) ?>
<?= $this->Form->end() ?>
