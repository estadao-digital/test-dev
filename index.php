<!doctype html>
<html class="no-js" lang="pt-br">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap -->
  <!-- Place favicon.ico in the root directory -->
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/css/mdb.min.css" rel="stylesheet">

<!-- JavaScript -->
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/alertify.min.js"></script>

<!-- CSS -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/alertify.min.css"/>
<!-- Default theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/default.min.css"/>
<!-- Semantic UI theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/semantic.min.css"/>
<!-- Bootstrap theme -->
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.11.4/build/css/themes/bootstrap.min.css"/>


</head>

<body class="d-flex flex-column h-100">
  <header>
  <!-- Fixed navbar -->
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark primary-color">

  <!-- Navbar brand -->
  <a class="navbar-brand" href="#">Teste Dev</a>

  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">

    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="#" onclick="carregar('carros.php')">Carros Cadastrados
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="modal" data-target="#modelId">Cadastrar novo</a>
      </li>
    </ul>
    <!-- Links -->
  </div>
  <!-- Collapsible content -->
</nav>
<!--/.Navbar-->
</header>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
  <div class="container" style="margin-top:5%;">
    <div id="tabela"></div>
  </div>
</main>

<footer class="footer mt-auto py-3">
  <div class="container">
    <hr>
    <span class="text-muted">AndersonCS</span>
  </div>
</footer>


<!-- Modal  cadastrar-->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Cadastro novo carro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="formCadastra">
            <div class="row">
              <div class="col-sm">
                <label for="">Marca</label>
                <select name="marca" id="marca" class="form-control">
                  <option value="Chevrolet">Chevrolet</option>
                  <option value="Fiat">Fiat</option>
                  <option value="Volkswagen">Volkswagen</option>
                  <option value="Ford">Ford</option>
                  <option value="Hyundai">Hyundai</option>
                  <option value="Toyota">Toyota</option>
                  <option value="Renault">Renault</option>
                </select>
                <div class="invalid-feedback">
                  Este campo e obrigátorio.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <label for="">Modelo</label>
                <input type="text" class="form-control" name="modelo" id="modelo">
                <div class="invalid-feedback">
                  Este campo e obrigátorio.
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <label for="">Ano</label>
                <input type="text" class="form-control" name="ano" id="ano">
                <div class="invalid-feedback">
                  Este campo e obrigátorio.
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnCadastra" data-dismiss="modal" class="btn btn-primary">Cadastrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Editar" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Editar carro</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
      <div class="modal-body">
        <div class="container-fluid">
          <form id="formEdita">
            <div class="row">
              <div class="col-sm">
                <label for="">Marca</label>
                <select name="marcaU" id="marcaU" class="form-control">
                  <option value="Chevrolet">Chevrolet</option>
                  <option value="Fiat">Fiat</option>
                  <option value="Volkswagen">Volkswagen</option>
                  <option value="Ford">Ford</option>
                  <option value="Hyundai">Hyundai</option>
                  <option value="Toyota">Toyota</option>
                  <option value="Renault">Renault</option>
                </select>
                <input type="hidden" name="idU" id="idU">
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <label for="">Modelo</label>
                <input type="text" class="form-control" name="modeloU" id="modeloU">
              </div>
            </div>
            <div class="row">
              <div class="col-sm">
                <label for="">Ano</label>
                <input type="text" class="form-control" name="anoU" id="anoU">
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" id="btnEdita" data-dismiss="modal" class="btn btn-primary">Editar</button>
      </div>
    </div>
  </div>
</div>

<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.8/js/mdb.min.js"></script>
 

  <script>
    function carregar(pagina){
      $('#tabela').load(pagina);
    }
  </script>
  <script>
    function apagar(id){
      alertify.confirm("Deseja mesmo apagar este carro?",
      function(){

        $.ajax({
          type:"POST",
          data:"id="+id,
          url:"apagar_carro.php",
          success:function(r){
            if(r == 1){
              alertify.success('Apagado com sucesso');
              $('#tabela').load('carros.php');
            }else{
              alertify.error('Erro ao apagar');
            }
          }
        });
        
      },
      function(){
        alertify.error('Cancelado');
      });
    }
  </script>

  <script>
    $(document).ready(function(){
      $('#btnCadastra').click(function(){

        if($('#marca').val() == ""){
          $('#marca').removeClass('form-control').addClass('form-control is-invalid');
          return false;
        }

        if($('#modelo').val() == ""){
          $('#modelo').removeClass('form-control').addClass('form-control is-invalid');
          return false;
        }

        if($('#ano').val() == ""){
          $('#ano').removeClass('form-control').addClass('form-control is-invalid');
          return false;
        }
        
        dados = $('#formCadastra').serialize();

        $.ajax({
          type:"POST",
          data:dados,
          url:"cadastra_carros.php",
          success:function(r){
            if(r == 1){
              $('#formCadastra')[0].reset();
              alertify.success('Carro criado com sucesso');
              $('#tabela').load('carros.php');
            }else{
              alertify.error('Erro ao criar o carro');
            }
          }
        });
      });
    });
    
  </script>

  <script>
    function obterDados(id){
      $.ajax({
        type:"POST",
        data:"id="+id,
        url:"obterDados.php",
        success:function(r){
          dado=jQuery.parseJSON(r);

          $('#idU').val(dado['id']);
          $('#modeloU').val(dado['Modelo']);
          $('#marcaU').val(dado['Marca']);
          $('#anoU').val(dado['Ano']);
        }

      });
    }
  </script>
  <script>
   $(document).ready(function(){
      $('#btnEdita').click(function(){
        
        dados = $('#formEdita').serialize();

        $.ajax({
          type:"POST",
          data:dados,
          url:"editar_dados.php",
          success:function(r){
            if(r == 1){
              alertify.success('Carro editado com sucesso');
              $('#tabela').load('carros.php');
            }else{
              alertify.error('Erro ao editar o carro');
            }
          }
        });
      });
    });
  </script>
</body>

</html>
