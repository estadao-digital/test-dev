<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

namespace Application\Model;


final class Router
{
    public $controller;

    public function __construct($router)
    {
        if (isset($router)) {
            $get = explode("/", $router);
            unset($_GET['p']);
            foreach ($get as $key => $value) {
                if($value != ''){
                    $_GET[$key] = $value;
                }
            }
        }

        $get = $_GET;
        
        switch (count($get))
        {
            case 0: {
                $this->controller = 'Application\Controller\HomeController';
                break;
            }
            case 1: {
                $this->controller = 'Vehicle\Controller\VehicleController';
                break;
            }
            case 2: {
                $this->controller = 'Vehicle\Controller\VehicleController';
                break;
            }
            default :{
                header('Location: /');
                break;
            }
        }

        return $this->controller;
    }
}