<?= $this->Form->create($user, ['class' => 'form-signin']) ?>

<h1 class="h3 mb-3 font-weight-normal">Cadastrar</h1>

<?= $this->Flash->render(); ?>


<div class="form-group">
    <label>Nome</label>
    <?= $this->Form->control('name', ['class'=> 'form-control', 'placeholder' => 'Nome completo', 'label' => false]) ?>
</div>

<div class="form-group">
    <label>E-mail</label>
    <?= $this->Form->control('email', ['class'=> 'form-control', 'placeholder' => 'Digite o seu E-mail', 'label' => false]) ?>
</div>

<div class="form-group">
    <label>Usuário</label>
    <?= $this->Form->control('username', ['class'=> 'form-control', 'placeholder' => 'Digite o usuário', 'label' => false]) ?>
</div>

<div class="form-group">
    <label>Senha</label>
    <?= $this->Form->control('password', ['class'=> 'form-control', 'placeholder' => 'Digite a senha', 'label' => false]) ?>
</div>

<?= $this->Form->button(__('Cadastrar'), ['class' => 'btn btn-lg btn-success btn-block']) ?>

<p class="text-center">
<?= $this->Html->link(__('Clique aqui '), ['Controller' => 'Users', 'action' => 'login']) ?>
para acessar
</p>

<?= $this->Form->end() ?>
