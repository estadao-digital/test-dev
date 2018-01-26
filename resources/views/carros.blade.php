<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <title>test-dev</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
        {{--  <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
        <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">  --}}
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    </head>
    <body>  
        
        <div class="container">
            <div>
                <h2>Todos os Carros</h2>
            </div>
            <div id="carrosList"></div>
            <br>
            <button class="btn btn-default" id="btnNovoCarro">Novo Carro</button>
            <br>
            <div id="carro"></div>
        </div>
 
        <script src="{{ mix('js/app.js') }}"></script>
        {{--  <script>
            $(document).ready(console.log("Carregamento Terminado !!!"));
        </script>  --}}
    </body>
</html>
