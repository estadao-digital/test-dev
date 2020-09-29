<?php

use Slim\App;
use Pixie\Connection;

return function (App $app) {
  $settings = $app->getContainer()->get('settings');

  return new Connection(
    $settings['db']['driver'],
    $settings['db'],
    'Pixie'
  );
};
