<?php

$page = '
<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/vendor/modernizr-2.8.3.min.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
</head>

<body>
  <h1>Olá</h1>
  <input id="modelo_valor" type="text" placeholder="digite o modelo">
  <div id="marcas_lista"></div>
  <input id="ano_valor" type="text" placeholder="digite o ano">
  <button onClick="adicionaCarro();">Cria</button>

  <script src="js/main.js"></script>
</body>

</html>';