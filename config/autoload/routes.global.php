<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\AuraRouter::class,
            App\Action\PingAction::class => App\Action\PingAction::class,
        ],
        'factories' => [
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
            App\Action\CarrosAction::class => App\Action\CarrosFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'home',
            'path' => '/',
            'middleware' => App\Action\HomePageAction::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'carros',
            'path' => '/carros',
            'middleware' => App\Action\CarrosAction::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'carros.carro',
            'path' => '/carros/{carro}',
            'middleware' => App\Action\CarrosAction::class,
            'allowed_methods' => ['GET', 'PUT', 'DELETE'],
            'options'         => [
                'constraints' => [
                    'tokens' => [
                        'carro' => '\d+',
                    ],
                ],
            ],
        ],
    ],
];
