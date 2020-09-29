<?php

use Slim\App;

return function (App $app) {
  $brandsRouter = require __DIR__ . '/../app/Modules/Brands/Infra/Http/Routes/BrandsRoutes.php';
  $brandsRouter($app);

  $carRouter = require __DIR__ . '/../app/Modules/Cars/Infra/Http/Routes/CarsRoutes.php';
  $carRouter($app);
};
