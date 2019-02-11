<?php

//Rota inicial da aplicação retorna a view 'home' o arquivo desta view está em /resources/views/home.blade.php
Route::get('/', function () {
    return view('home');
});