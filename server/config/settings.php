<?php

use Psr\Container\ContainerInterface as Container;

return function (Container $container) {
  $container->set('settings', function () {
    return [
      'displayErrorDetails' => true,
      'logErrors' => true,
      'logErrorDetails' => true,
      'db' => [
        'driver' => 'sqlite',
        'database' => __DIR__ . '/../database/db.sqlite',
        'prefix' => '',
      ],
    ];
  });
};
