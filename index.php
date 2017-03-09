<!doctype html>
<html class="no-js" lang="" ng-app>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <link rel="stylesheet" href="css/main.css">
</head>
<body>
  <header>
    <div class="container">
      <input type="text" id="search" placeholder="Digite aqui o que deseja encontrar"/>
      <a   onclick="adicionar()" href="form.html" data-toggle="modal" class="showModal btn-new">Novo carro</a>
    </div>
  </header>
  <section class="content">
    <div class="container">
      <ul class="list-boxes result" id="list-car" ng-controller="carrosController">
       <li ng-repeat="item in itens" class="col-xs-12 col-sm-6 col-lg-4 item-car" title="{{ item.carro }}">
        <div class="box">
          <figure class="img-car">
            <div class="shadow"></div>
            <img ng-src="carros/upload/{{ item.img }}.jpg" alt="{{ item.carro }}" title="{{ item.carro }}" class="img-responsive" />
          </figure>
          <div class="description">
            <h2>
              <span class="model">{{ item.carro }} <small class="data">{{ item.dataano }}/{{ item.datamodelo }}</small></span>
              <span class="version">{{ item.modelo }}</span>
            </h2>
            <div class="brand">
              <i class="{{ item.marca }}" alt="{{ item.marca }}" title="{{ item.marca }}"></i>
            </div>
            <div class="actions">
              <a href="" class="glyphicon glyphicon-trash" title="Remover"></a>
              <a href="form.html" id="{{ item.id }} " onclick="atualizar(this.id)" data-toggle="modal" class="showModal glyphicon glyphicon-edit" title="Editar"></a>
            </div>
          </div>
        </div>
      </li>
    </ul>
  </div>
</section>


<script type="text/javascript" src="js/vendor/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/vendor/modernizr-2.8.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap/bootstrap.js"></script>
<script type="text/javascript" src="js/angular.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" type="text/javascript">
function carrosController($scope) {
    $scope.itens = <?php
    $link =  'http://localhost/test-dev/carros/index.php';
    $conteudo = curl_download($link);
    echo $conteudo;

    function curl_download($url){
        $session = curl_init();
        curl_setopt($session, CURLOPT_URL, $url);
        curl_setopt($session, CURLOPT_POST, 1);
        curl_setopt($session, CURLOPT_POSTFIELDS,
        http_build_query(array('func' => 'GET')));
        
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($session);
        curl_close($session);
        
        return $output;
    }?>
    ;
  }
  function formController($scope) {
      $scope.itens = [{"id":"1","marca":"Ford","carro":"tsatsa","modelo":"tsatattsa","dataano":"undefined","datamodelo":"undefined"}] ;
  }
    
  var caminho;
  function adicionar(){
      caminho=`POST`;
  }
  function atualizar(id){
      var dados;
      caminho=`GET`;
      console.log(id);
      var data = new FormData();
      data.append('func',caminho);
      data.append('id',id);
      $.ajax({
          url :  "/test-dev/carros/index.php",
          type: 'POST',
          data: data,
          contentType: false,
          processData: false,
          success: function(data) {
              dados= data;
          },
          error: function() {
          }
      });
  }
  function enviar(){
      var data = new FormData();
      data.append('func',caminho);
      data.append('marca',$( "#marca" ).val());
      data.append('carro',$( "#carro" ).val());
      data.append('modelo',$( "#modelo" ).val());
      data.append('dataano',$( "#data-ano" ).val());
      data.append('datamodelo',$( "#data-modelo" ).val());
      data.append( 'foto', $( '#foto' )[0].files[0] );
      $.ajax({
          url :  "/test-dev/carros/index.php",
          type: 'POST',
          data: data,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
          },
          error: function() {
          }
      });
      carrosController();
  }
</script>
</body>
</html>