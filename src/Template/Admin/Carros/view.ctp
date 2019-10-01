<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Carro</h2>
    </div>
    <div class="p-2">
        <span class="d-none d-md-block">
            <?= $this->Html->link(__('Listar'), ['controller' => 'carros', 'action' => 'index'], ['class' => 'btn btn-outline-info btn-sm']) ?>

            <?= $this->Html->link(__('Editar'), ['controller' => 'carros', 'action' => 'edit', $carro->id], ['class' => 'btn btn-outline-warning btn-sm']) ?>

            <?= $this->Form->postLink(__('Apagar'), ['controller' => 'carros', 'action' => 'delete', $carro->id], ['class' => 'btn btn-outline-danger btn-sm', 'confirm' => __('Realmente deseja apagar este carrro # {0}?', $carro->id)]) ?>

        </span>
        <div class="dropdown d-block d-md-none">
            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Ações
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                <?= $this->Html->link(__('Listar'), ['controller' => 'carros', 'action' => 'index'], ['class' => 'dropdown-item']) ?>

                <?= $this->Html->link(__('Editar'), ['controller' => 'carros', 'action' => 'edit', $carro->id], ['class' => 'dropdown-item']) ?>

                <?= $this->Form->postLink(__('Apagar'), ['controller' => 'users', 'action' => 'delete', $carro->id], ['class' => 'dropdown-item', 'confirm' => __('Realmente deseja apagar o carro # {0}?', $carro->id)]) ?>                                    
            </div>
        </div>
    </div>
</div><hr>

<dl class="row">
    <dt class="col-sm-3">ID</dt>
    <dd class="col-sm-9"><?= $this->Number->format($carro->id) ?></dd>

    <dt class="col-sm-3">Marca</dt>
    <dd class="col-sm-9"><?= h($carro->marca) ?></dd>

    <dt class="col-sm-3">Modelo</dt>
    <dd class="col-sm-9"><?= h($carro->modelo) ?></dd>

    <dt class="col-sm-3">Ano</dt>
    <dd class="col-sm-9"><?= h($carro->ano) ?></dd>

    <dt class="col-sm-3 text-truncate">Cadastro</dt>
    <dd class="col-sm-9"><?= h($carro->created) ?></dd>

    <dt class="col-sm-3 text-truncate">Alteração</dt>
    <dd class="col-sm-9"><?= h($carro->modified) ?></dd>

</dl>

