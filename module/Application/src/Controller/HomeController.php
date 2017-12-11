<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 02/11/17
 */

namespace Application\Controller;


use Application\Model\Render;

class HomeController extends Render
{
    public $view;

    public function index()
    {
        $view = 'module/Application/view/home.phtml';

        $this->render($view);
    }

}