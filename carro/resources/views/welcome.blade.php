<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Carro</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
     
    </head>
    <body>
        <div class="flex-center position-ref full-height">

            <div class="content">
                <div class="card text-center">
                    <div class="card-header">
                      Carros
                    </div>
                    <div class="card-body">
                      <h5 class="card-title">Eduardo Dantas Correia</h5>
                      <p class="card-text">Teste dev-test cliente Estadão</p>
                      <a href="{{ route('carros.index') }}" class="btn btn-primary">Entrar</a>
                    </div>
                    <div class="card-footer text-muted">
                      Laravel
                    </div>
                  </div>

            </div>
        </div>
    </body>
</html>
