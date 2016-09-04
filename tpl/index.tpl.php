<!doctype html>
<html class="no-js" lang="">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <!-- Place favicon.ico in the root directory -->
  <link href="bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <script src="js/sorttable.js"></script>
  <script src="js/vendor/modernizr-2.8.3.min.js"></script>
  <script src="js/main.js"></script>
</head>
<body>
  <nav class="navbar navbar-inverse navbar-fixed-top" style="font-family: Arial;">
    <div class="container" style="font-family: Arial;">
      <div class="navbar-header" style="font-family: Arial;">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar" style="font-family: Arial;">
          <span class="sr-only" style="font-family: Arial;">Toggle navigation</span>
          <span class="icon-bar" style="font-family: Arial;"></span>
          <span class="icon-bar" style="font-family: Arial;"></span>
          <span class="icon-bar" style="font-family: Arial;"></span>
        </button>
      </div>
      <div id="navbar" class="navbar-collapse collapse" style="font-family: Arial;">
        <ul class="nav navbar-nav" style="font-family: Arial;">
            <li style="font-family: Arial;" onclick="call_ajax('GET','home','')"><a>Home</a></li>y
            <li style="font-family: Arial;" onclick="call_ajax('GET','carros','')"><a>Ver Todos</a></li>
            <li style="font-family: Arial;" onclick="call_ajax('GET','carro','')"><a>Incluir Novo Carro</a></li>
            <li style="font-family: Arial;" onclick="call_ajax('GET','carros/buscar','')"><a>Buscar Carro</a></li>
      </ul>
    </div><!--/.nav-collapse -->
  </div>
</nav>
<div class="container theme-showcase" role="main" style="font-family: Arial;">
  <div class="jumbotron main_jumbo container" style="font-family: Arial;">
    <div id="retorno_base"  class="container">
      <h1 style="font-family: Arial;">Teste de Desenvolvimento</h1>
      <p style="font-family: Arial;">Aplicação Carros com o objetivo de desenvolver uma 'mini api' para que seja possível realizar operações CRUD do objeto Carro.</p>
    </div>
  </div>
</div>     
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.3.min.js"><\/script>')</script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

</body>
</html>
