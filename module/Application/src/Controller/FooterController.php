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

class FooterController
{
    public function render()
    {
        $view = 'module/Application/view/footer.phtml';

        include($view);
    }
}