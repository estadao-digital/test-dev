<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

namespace Application\Controller;

use Application\Model\Render;
use Application\Model\Router;
use Application\Controller\HeadController;
use Application\Controller\FooterController;

class IndexController
{
    protected $view;
    protected $router;

    public function __construct($router)
    {
        $this->router = new Router($router);

        $this->view = 'module/Application/view/index.phtml';
    }

    public function render()
    {
        $head    = new HeadController();

        $content = new $this->router->controller();

        $footer  = new FooterController();

        include($this->view);
    }

    public function &factory($className)
    {
        require_once($className.'php');

        if(class_exists($className)) return new $className;

        die('Cannot create new "'.$className.'" class - includes not found or class unavailable.');
    }
}