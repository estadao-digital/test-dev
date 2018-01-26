<?php

Route::any('{all}', function(){
    return view('carros');
})->where('all', '.*');