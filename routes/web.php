<?php

Route::get('/',[ 'as' => 'main', 'uses' => '\Cars\ShowCase\Http\ShowCaseController@index' ]);    


Route::group(['prefix' => 'services'], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::group(['prefix' => 'carros'], function () {
            Route::get('/form-grid',[ 'as' => 'form-grid-view', 'uses' => '\Cars\ShowCase\Http\ShowCaseController@formGridView' ]);     
            Route::get('/grid',[ 'as' => 'grid-view', 'uses' => '\Cars\ShowCase\Http\ShowCaseController@gridView' ]);     
            Route::post('/',[ 'as' => 'create-car', 'uses' => '\Cars\Admin\Http\CarController@create' ]);     
            Route::get('/{id}',[ 'as' => 'edit-car', 'uses' => '\Cars\Admin\Http\CarController@findById' ]);     
            Route::put('/{id}',[ 'as' => 'update-car', 'uses' => '\Cars\Admin\Http\CarController@update' ]);     
            Route::delete('/{id}',[ 'as' => 'update-car', 'uses' => '\Cars\Admin\Http\CarController@remove' ]);     
        });
    });
});