<?php

namespace Application\Server\Controller
{
    use Application\Server\Controller;

    class Car extends \Controller
    {
        public static function onRequest($input)
        {
            return self::success(['cars' => Controller\API\Car\GetAll::execute()->cars]);
        }

        public static function onRender($response)
        {
            $render = new \Render\Front();
            $render->addViewFromPath('view://Car.html.twig');
            return $render;
        }
    }
}