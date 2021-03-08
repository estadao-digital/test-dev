<?php

namespace Application\Server\Controller
{
    class Index extends \Controller
    {
        public static function onRequest($input)
        {
            return \Header::redirect('/car');
        }
    }
}