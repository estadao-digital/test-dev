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
            <br><br><br>
            <button class="btb-">Seed Carros</button>
            <button class="btb-">Limpa Carros</button>
            <button class="btb-" id="btnNovoCarro">Novo Carro</button>
            <br><br><br>
            <div>Todos os Carros</div>
            <div id="carrosList"></div>
            <br>
            <br>
            <div id="carro"></div>
        </div>
        
        <br><br><br>
        <br><br><br>
        <br><br><br>

        <input type="text" list="browsers" name="myBrowser" /></label>
        
        <datalist id="browsers">
            <option value="Chrome">
            <option value="Firefox">
            <option value="Internet Explorer">
            <option value="Opera">
            <option value="Safari">
            <option value="Microsoft Edge">
        </datalist>

        <script src="{{ mix('js/app.js') }}"></script>
        {{--  <script>
            $(document).ready(console.log("Carregamento Terminado !!!"));
        </script>  --}}
    </body>
</html>
