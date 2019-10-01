<?= $this->Form->create('post', ['class' => 'form-signin']) ?>

<?= $this->Html->image('logo_estadao_single.png', ['class' => 'mb-4', 'alt' => 'Celke', 'width' => '100', 'height'=>'100']) ?>

<h1 class="h3 mb-3 font-weight-normal">Área Restrita</h1>

<?= $this->Flash->render(); ?>

<div class="form-group">
    <label>Usuário</label>
    <?= $this->Form->control('username', ['class'=> 'form-control', 'placeholder' => 'Digite o usuário', 'label' => false]) ?>
</div>

<div class="form-group">
    <label>Senha</label>
    <?= $this->Form->control('password', ['class'=> 'form-control', 'placeholder' => 'Digite a senha', 'label' => false]) ?>
</div>

<?= $this->Form->button(__('Acessar'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

<p class="text-center">
    <?= $this->Html->link(__('Cadastrar'), ['class' => 'btn btn-danger', 'Controller' => 'Users', 'action' => 'cadastrar']) ?> - Esqueceu a senha?
</p>

<?= $this->Form->end() ?>
