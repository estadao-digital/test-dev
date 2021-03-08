<?php

namespace Garbage
{
    class Collector
    {
        public static function isEnabled()
        { return (@function_exists("gc_enabled") == true && @gc_enabled() == true); }

        public static function isDisabled()
        { return (!self::isEnabled()); }

        public static function enable()
        { if (@function_exists("gc_enable")) @gc_enable(); }

        public static function disable()
        { if (@function_exists("gc_disable")) @gc_disable(); }

        public static function collect()
        { if (self::isEnabled() && @function_exists("gc_collect_cycles")) @gc_collect_cycles(); }
    }
}
