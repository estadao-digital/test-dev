<?php

return [
    [
        'url' => '/api/marcas',
        'method' => 'get',
        'hasAuth' => false,
        'controller' => [
            'namespace' => 'app\controllers\MarcaController',
            'action' => 'index',
        ],
    ],
    [
        'url' => '/api/carros',
        'method' => 'get',
        'hasAuth' => false,
        'controller' => [
            'namespace' => 'app\controllers\CarroController',
            'action' => 'index',
        ]
    ],
    [
        'url' => '/api/carros/:id',
        'method' => 'delete',
        'hasAuth' => false,
        'controller' => [
            'namespace' => 'app\controllers\CarroController',
            'action' => 'delete'
        ],
    ],
    [
        'url' => '/api/carros/:id',
        'method' => 'put',
        'hasAuth' => false,
        'controller' => [
            'namespace' => 'app\controllers\CarroController',
            'action' => 'update'
        ],
    ],
    [
        'url' => '/api/carros/:id',
        'method' => 'get',
        'hasAuth' => false,
        'controller' => [
            'namespace' => 'app\controllers\CarroController',
            'action' => 'getOne'
        ],
    ],
    [
        'url' => '/api/carros',
        'method'=> 'post',
        'controller' => [
            'namespace' => 'app\controllers\CarroController',
            'action' => 'create',
        ]
    ]
];