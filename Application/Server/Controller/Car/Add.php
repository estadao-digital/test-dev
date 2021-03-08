<?php

namespace Application\Server\Controller\Car
{
    class Add extends \Controller
    {
        public static function onRequest($input)
        {
            return self::success();
        }

        public static function onRender($response)
        {
            $render = new \Render\Front();
            $render->addViewFromPath('view://Car/Edit.html.twig');
            return $render;
        }
    }
}