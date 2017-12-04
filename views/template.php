<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teste Dev</title>        
    <?php require_once './views/blocks/block_head.php'; ?>
</head>
<body>
    <div class="blockpage hidden">
        <img src="<?php echo BASE ?>/assets/images/loading.gif" class="loading"/>
    </div>
    <nav class="navbar navbar-inverse">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>  
                <span class="img navbar-brand to-content"  data-href="<?php echo BASE ?>/listar">                              
                    <i class="fa fa-home" aria-hidden="true"></i> 
                </span>
            </div>
            <div id="navbar" class="navbar-collapse collapse">                                
                <ul class="nav navbar-nav navbar-right">                                  
                    <li><a href="<?php echo BASE; ?>vendas">Minhas Vendas</a></li>
                    <li><a href="javascript:void(0)">Minhas Compras</a></li>
                    <li><a href="javascript:void(0)">Meus Anúncios</a></li>
                    <li class="dropdown">                                                      
                        <span class="caret to-content" data-href="<?php echo BASE ?>/listar"></span>                        
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo BASE; ?>perfil">Editar Perfil</a></li>
                            <li><a href="<?php echo BASE; ?>login/sair">Sair</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>   
    <div id="content"></div>
    <?php require_once './views/blocks/block_footer.php'; ?>
</body>
</html>
