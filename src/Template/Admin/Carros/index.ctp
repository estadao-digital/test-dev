<div class="d-flex">
    <div class="mr-auto p-2">
        <h2 class="display-4 titulo">Listar Carros</h2>
    </div>
        <div class="p-2">
            <?= $this->Html->link(__('Cadastrar'),['controller' => 'carros','action' => 'add'], ['class' => 'btn btn-outline-success btn-sm']);
            ?>
        </div>
</div>
<?= $this->Flash->render() ?>
<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Marca</th>
                <th class="d-none d-sm-table-cell">Modelo</th>
                <th class="d-none d-lg-table-cell">Ano</th>
                <th class="d-none d-lg-table-cell">Data do Cadastro</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($carros as $carro): ?>
                <tr>
                    <td><?= $this->Number->format($carro->id) ?></td>
                    <td><?= h($carro->marca) ?></td>
                    <td class="d-none d-sm-table-cell">
                        <?= h($carro->modelo) ?>
                    </td>
                    <td class="d-none d-sm-table-cell">
                        <?= h($carro->ano) ?>
                    </td>
                    <td class="d-none d-lg-table-cell">
                        <?= h($carro->created) ?>                            
                    </td>
                    <td>
                        <span class="d-none d-md-block">
                            <?= $this->Html->link(__('Visualizar'), ['controller' => 'carros', 'action' => 'view', $carro->id], ['class' => 'btn btn-outline-primary btn-sm']) ?>

                            <?= $this->Html->link(__('Editar'), ['controller' => 'carros', 'action' => 'edit', $carro->id], ['class' => 'btn btn-outline-warning btn-sm']) ?>

                            <?= $this->Form->postLink(__('Apagar'), ['controller' => 'carros', 'action' => 'delete', $carro->id], ['class' =>'btn btn-outline-danger btn-sm', 'confirm' => __('Realamente deseja apagar o carro # {0}?', $carro->id)]) ?>
                        </span>  
                        <div class="dropdown d-block d-md-none">
                            <button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="acoesListar" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Ações
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="acoesListar">
                                <?= $this->Html->link(__('Visualizar'), ['controller' => 'carros', 'action' => 'view', $carro->id], ['class' => 'dropdown-item']) ?>

                                <?= $this->Html->link(__('Editar'), ['controller' => 'carros', 'action' => 'edit', $carro->id], ['class' => 'dropdown-item']) ?>

                                <?= $this->Form->postLink(__('Apagar'), ['controller' => 'carros', 'action' => 'delete', $carro->id], ['class' =>'dropdown-item', 'confirm' => __('Realamente deseja apagar o carro # {0}?', $carro->id)]) ?>
                            </div>
                        </div>                         
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?= $this->element('pagination'); ?>
</div>
