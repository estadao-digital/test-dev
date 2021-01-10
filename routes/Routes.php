<?php
namespace Routes;

use Core\Router;
use App\Controllers\CarsController;
use App\Controllers\BrandsController;
use App\Views\CarsView;
use App\Tests\Tests;
use Core\Utilities;
use Core\Output;

class Routes{
    private $carsControllers;
    private $brandsControllers;

    public function __construct(){
        $this->initRoutes();
    }

    public function initRoutes(){
        $this->carsControllers= new CarsController();
        $this->brandsControllers= new BrandsController();

        $router = new Router();
        $router
        ->on('GET','/', function () {
          echo CarsView::index();
          })
        ->on('GET','/api/cars', function () {
          Output::JSON($this->carsControllers->index());
          })
        ->on('GET','/api/cars/show((/[a-zA-Z0-9-]+)?)', function ($id) {
          Output::JSON($this->carsControllers->show(str_replace("/","",$id)));
        })
        ->on('POST','/api/cars/new', function () {
          Output::JSON( $this->carsControllers->store(filter_input_array(INPUT_POST, FILTER_SANITIZE_STRIPPED)));
          })
        ->on('DELETE','/api/cars/delete((/[a-zA-Z0-9-]+)?)', function ($id) {
          Output::JSON($this->carsControllers->delete(str_replace("/","",$id)));
          })
        ->on('PUT','/api/cars/update((/[a-zA-Z0-9-]+)?)', function ($id) {
          Output::JSON($this->carsControllers->update(str_replace("/","",$id),Utilities::ParsePut()));
          })
          ->on('GET','/api/brands', function () {
            Output::JSON($this->brandsControllers->index());
            })
          ->on('GET','/tests', function () {
            Tests::runTests();
           })

        ->get('/(\w+)', function ($w) {
            header("HTTP/1.1 404 Not Found");
            exit("Endpoint não existente!");
        });
        function url($path)
        {
            return str_replace('//', '/', '/' . $path);
        }
        echo $router($router->method(), $router->uri());
    }

   
}
