<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Teste para desenvolvedor do Estadão</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
<div id="app">
    <main-app />
</div>
<footer class="footer mt-auto py-3">
    <div class="container">
        <span class="text-muted">Desenvolvido por <a href="mailto:maxwillian63@gmail.com">Max Willian</a></span>
    </div>
</footer>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
