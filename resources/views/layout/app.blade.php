<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ config('app.name') }}</title>

    <!-- Core -->
    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet">
    <!-- Plugin CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Custom styles for this template -->

</head>

<body id="page-top">

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light" id="nav-header">
    <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#">
           CondeCarros
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="info nav-link" href="#sobre">Informações</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
<section id="banner" class="background-dark text-white banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h2>Test-dev Estadão</h2>
            </div>
        </div>

    </div>
</section>
@yield('content')

<footer class="footer background-dark">
    <div class="text-center center-block">
        <a href="https://www.linkedin.com/in/rodolfoconde/" target="_blank"><i class="fa  fa-linkedin fa-2x social" aria-hidden="true"></i></a>
        <a href="https://bitbucket.org/rodolfoconde/" target="_blank"><i class="fa fa-bitbucket fa-2x social" aria-hidden="true"></i></a>
        <a href="https://github.com/rodolfoconde" target="_blank"><i class="fa fa-github fa-2x social" aria-hidden="true"></i></a>
    </div>
</footer>

<div id="info" style="display: none">
    <div class="container">
    <h2>Olá</h2>
    <p>Apresento o projeto desenvolvido em laravel para o Estadão, utilizando:</p>
    <ul>
        <li>Laravel 5.4</li>
        <li>MySQL</li>
        <li>Bootstrap</li>
        <li>Gulp</li>
    </ul>

    <p>Meu nome é Rodolfo Conde e gostaria de bater um papo para me apresentar, obrigado pela oportunidade.</p>
    </div>
</div>

<div id="modal-alert" style="display: none">

</div>

<div id="modal-cadastro" style="display: none">
    <div class="container" style="padding: 10px;">
    <form class="form-horizontal modal-cadastrar">
        <fieldset>
            <div class="control-group">
                <label class="control-label"  for="username">Marca</label>
                <div class="controls">
                    <input type="text" id="marca" name="marca" placeholder="" class="form-control">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="email">Modelo</label>
                <div class="controls" class="form-control">
                    <input type="text" id="modelo" name="modelo" placeholder="" class="form-control">
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="password">Ano</label>
                <div class="controls" >
                    <input type="text" id="ano" name="ano" placeholder="" class="form-control">
                </div>
            </div>


            <div class="control-group pull-right">
                <div class="controls">
                    <button class="btn btn-success">Cadastrar</button>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
</div>


<div id="modal-editar" style="display: none" data-id="">
    <div class="container" style="padding: 10px;">
        <form class="form-horizontal modal-alterar">
            <fieldset>
                <div class="control-group">
                    <label class="control-label"  for="username">Marca</label>
                    <div class="controls">
                        <input type="text" id="marca" name="marca" placeholder="" value="" class="form-control">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="email">Modelo</label>
                    <div class="controls" class="form-control">
                        <input type="text" id="modelo" name="modelo" placeholder="" value="" class="form-control">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="password">Ano</label>
                    <div class="controls" >
                        <input type="text" id="ano" name="ano" placeholder=""  value="" class="form-control">
                    </div>
                </div>


                <div class="control-group pull-right">
                    <div class="controls">
                        <button class="btn btn-success" >Salvar</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>





<!-- Bootstrap core JavaScript -->
<script src="{{ asset('js/core.min.js') }}"></script>

<!-- Plugin JavaScript -->
<script src="{{ asset('js/components.min.js') }}"></script>
<script src="https://blackrockdigital.github.io/startbootstrap-creative/vendor/scrollreveal/scrollreveal.min.js"></script>

<script src="{{ asset('js/cars.js') }}"></script>

<script>



</script>


</body>

</html>