<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Página única para teste</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <!-- Place favicon.ico in the root directory -->

        <link rel="stylesheet" href="<?=Funcoes::asset('css/bootstrap.min.css');?>">
        <link rel="stylesheet" href="<?=Funcoes::asset('css/main.css');?>">
        <script src="<?=Funcoes::asset('js/vendor/modernizr-2.8.3.min.js');?>"></script>
    </head>
    <body>
        <h1>Teste Estadão</h1>

        <p>Para avaliação e vaga para programador PHP, segue meu teste aplicativo mini-api,
            devido a falta de tempo não foi feito a parte do javascript atualizar a tabela.</p>
        <p>&nbsp;</p>

        <p>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-insert">
                Incluir Carro
            </button>
        </p>
        <table class="table table-bordered" id="table-carros">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <!-- modais -->
        <?php include 'modal-include.php';?>
        <?php include 'modal-update.php';?>

        <!-- scripts -->
        <script src="<?=Funcoes::asset('js/vendor/jquery-1.11.3.min.js');?>"></script>
        <script src="<?=Funcoes::asset('js/vendor/bootstrap.min.js');?>"></script>
        <script src="<?=Funcoes::asset('js/main.js');?>"></script>
    </body>
</html>
