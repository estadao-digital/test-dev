<?php

namespace Application\Server\Controller\Car
{
    use Application\Server\Model;

    class Edit extends \Controller
    {
        protected static function onInput($type) { return [
            'carId' => int
        ]; }

        public static function onRequest($input)
        {
            $input = $input->get;

            $car = Model\Car::getByCarId($input->carId);
            if ($car === null || $car->deleted === true)
                return \Header::redirect('/car');

            return self::success(['car' => $car->toArr()]);
        }

        public static function onRender($response)
        {
            $render = new \Render\Front();
            $render->addViewFromPath('view://Car/Edit.html.twig');
            return $render;
        }
    }
}