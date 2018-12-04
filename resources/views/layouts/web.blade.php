<!DOCTYPE html>
<html lang="pt-br" itemscope itemtype="http://schema.org/WebPage">
<head>
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="HandheldFriendly" content="true">
    <meta name="keyworkds" content="">
    <meta name="description" content="" itemprop="description">
    <meta name="resource-type" content="document">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    <meta name="robots" content="index, follow">
    <meta name="alexa" content="100">
    <meta name="pagerank" content="10">
    <meta name="author" content="André Ezías">
    <meta property="og:title" content="">
    <meta property="og:site_name" content="">
    <meta property="og:url" content="">
    <meta property="og:description" content="">
    <meta property="og:image" content="">
    <meta property="og:app_id" content="">
    <meta property="og:type" content="website">
    <link rel="shortcut icon" href="">
</head>
<body>
<!--[if lt IE 8]>
<div class="alert alert-warning">
    Você está usando um <strong>Navegador Antigo</strong>.
    Por favor <a href="https://browsehappy.com/">atualize seu Navegador</a> para melhorar sua experiência em nosso site.
</div>
<![endif]-->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

@yield('content')
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
@stack('scripts')
</body>
</html>