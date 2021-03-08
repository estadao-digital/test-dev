<?php

namespace Security
{
    class Key
    {
        const TYPE_PLAIN = "plain";
        const TYPE_RS256 = "RS256";

        protected $type = self::TYPE_PLAIN;
        protected $key  = null;

        function __construct($keyString = null) {
            if (!stringEx($keyString)->isEmpty())
                $this->key = stringEx($keyString)->toString();
        }

        public function isValidKey()
        { return ($this->key != null); }

        public function getKey()
        { return $this->key; }

        public function getType()
        { return $this->type; }
    }
}