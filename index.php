<?php
    header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Teste Estadão - Luiz Pillon</title>
        <meta name="author" content="LuizPillon">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Teste Estadão API Carros, Luiz Pillon">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <link rel="icon" href="favicon.ico">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
    </head>
    <body>
        <div class="principal">
            <?php include_once "retornaCarros.php" ?>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>

        <script src="js/main.js"></script>

        <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    </body>
</html>
