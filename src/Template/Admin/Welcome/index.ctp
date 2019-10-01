<h2>Bem vindo <?php echo $user['name']; ?> </h2>
<?= $this->Html->link(__('Sair'), ['controller' => 'users' ,'action' => 'logout']) ?>
