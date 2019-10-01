<nav class="sidebar">
    <ul class="list-unstyled">
        <li><?= $this->Html->link(
            '<i class="fas fa-tachometer-alt"></i> Dashboard',
            [
                'controller' => 'welcome',
                'action' => 'index'
            ],
            [
                'escape'=> false
            ]
            ); ?>
        </li>

        <!-- <li><?= $this->Html->link(
            '<i class="fas fa-users"></i> Usuários',
            [
                'controller' => 'users',
                'action' => 'index'
            ],
            [
                'escape'=> false
            ]
            ); ?>
        </li> -->

        <li><?= $this->Html->link(
            '<i class="fas fa-car"></i> Carros',
            [
                'controller' => 'carros',
                'action' => 'index'
            ],
            [
                'escape'=> false
            ]
            ); ?>
        </li>

        <li><?= $this->Html->link(
            '<i class="fas fa-sign-out-alt"></i> Sair',
            [
                'controller' => 'users',
                'action' => 'logout'
            ],
            [
                'escape'=> false
            ]
            ); ?>
        </li>
    </ul>
</nav>

