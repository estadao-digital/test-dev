<?php

namespace {
    class JSON
    {
        public static function stringfy($value)
        { return \Serialize\Json::encode($value); }

        public static function parse($value)
        { return \Serialize\Json::decode($value); }
    }
}