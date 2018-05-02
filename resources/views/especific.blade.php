<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Estadão Digital</title>
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <!-- Styles -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
  <link rel="stylesheet" href="../resources/assets/css/style.css">
</head>
<body>
  <div class="jumbotron header">
    <div class="container">
      <h1 class="display-3">Estadão Digital</h1>
      <h4>Teste para desenvolvedor do Estadão</h4>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
    </div>
  </div>
  <nav class="navbar navbar-expand-md navbar-light  bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="register"><i class="fas fa-plus"></i> Cadastrar Carro</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="../public"><i class="fas fa-list"></i> Listar Carros</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="col-md-7 form">
    <h5><i class="far fa-edit"></i> Editando: {{ $car->modelo }}</h5>
    <div class="feedback"></div>
    <form class="form-horizontal" id="ajax">
      <div class="form-group">
        {{ csrf_field() }}
        <label>Marca* : </label>
        <select name="marca" id="marca" class="form-control">
          <option value="">Escolha uma marca...</option>
          @foreach($marcas as $m)
            <option value="{{$m->nome}}" <?php if($m->nome == $car->marca){echo "selected";}?>>{{$m->nome}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Modelo* : </label>
        <input type="text" name="modelo" id="modelo" class="form-control" value="{{ $car->modelo }}"/>
      </div>
      <div class="form-group">
        <label>Ano* : </label>
        <input type="number" name="ano" id="ano" class="form-control" value="{{ $car->ano }}"/>
      </div>
      <div class="form-group text-right">
        <input type="submit" id="ajaxSubmit" class="btn btn-info"/>
      </div>
    </form>
  </div>
  <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  <script>
  jQuery(document).ready(function(){
    jQuery('#ajaxSubmit').click(function(e){
      var carro = {{ $car->id }};
      var action = "api/carros/"+carro;
      e.preventDefault();
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
      });
      jQuery.ajax({
        url: action,
        method: 'put',
        data: {
          marca: jQuery('#marca').val(),
          modelo: jQuery('#modelo').val(),
          ano: jQuery('#ano').val()
        },
        success: function(result){
          jQuery('.feedback').show();
          jQuery('.feedback').html(result.success);
        }});
      });
    });
    </script>
  </body>
  </html>
