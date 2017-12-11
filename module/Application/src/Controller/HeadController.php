<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 02/11/17
 */

namespace Application\Controller;


class HeadController
{
    public function render()
    {
        $view = 'module/Application/view/head.phtml';

        include($view);
    }
}