<?php

namespace Application\Client\Component
{
    class Loader
    {
        protected static $isInitialized = false;

        protected static $loader    = null;
        protected static $loaderImg = null;

        public static function onInitialize($data)
        {
            if (self::$isInitialized === true)
                return null;
            self::$isInitialized = true;

            self::$loader    = \Element::find('.app-loading');
            self::$loaderImg = \Element::find('.app-loading img');

            if (self::$loader !== null) {
                self::$loader->style->add('opacity', 0);
                self::$loader->style->add('pointer-events', 'none');

                \FunctionEx::delay(function() {
                    self::$loader->style->add('background-color', '#000000');
                    self::$loaderImg->set('src', '/assets/img/loader-dialog.gif');
                }, 500);
            }
        }

        public static function show()
        {
            if (self::$loader === null)
                return null;

            self::$loader->style->add('opacity', 0.8);
            self::$loader->style->remove('pointer-events');
        }

        public static function hide()
        {
            if (self::$loader === null)
                return null;

            self::$loader->style->add('opacity', 0);
            self::$loader->style->add('pointer-events', 'none');
        }
    }
}