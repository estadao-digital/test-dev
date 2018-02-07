<?php

Route::resource('carros', 'CarroController', [
  'except' => ['create', 'edit']
]);
