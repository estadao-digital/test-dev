<?php

namespace KrupaBOX\Internal\Polyfill
{
    class PHP54
    {
        public static function hex2bin($data)
        {
            $len = strlen($data);
            if (null === $len) {
                return;
            }
            if ($len % 2) {
                trigger_error('hex2bin(): Hexadecimal input string must have an even length', E_USER_WARNING);
                return false;
            }
            return pack('H*', $data);
        }
    }
}

namespace
{
    use KrupaBOX\Internal\Polyfill;

    if (PHP_VERSION_ID < 50400)
    {
        if (!class_exists("CallbackFilterIterator"))
        {
            class CallbackFilterIterator extends FilterIterator
            {
                private $iterator;
                private $callback;

                public function __construct(Iterator $iterator, $callback)
                {
                    $this->iterator = $iterator;
                    $this->callback = $callback;
                    parent::__construct($iterator);
                }

                public function accept()
                { return call_user_func($this->callback, $this->current(), $this->key(), $this->iterator); }
            }
        }

        if (!class_exists("RecursiveCallbackFilterIterator"))
        {
            class RecursiveCallbackFilterIterator extends CallbackFilterIterator implements RecursiveIterator
            {
                private $iterator;
                private $callback;

                public function __construct(RecursiveIterator $iterator, $callback)
                {
                    $this->iterator = $iterator;
                    $this->callback = $callback;
                    parent::__construct($iterator, $callback);
                }

                public function hasChildren()
                { return $this->iterator->hasChildren(); }

                public function getChildren()
                { return new static($this->iterator->getChildren(), $this->callback); }
            }
        }

        if (!class_exists("SessionHandlerInterface"))
        {
            interface SessionHandlerInterface
            {
                public function open($savePath, $sessionName);
                public function close();
                public function read($sessionId);
                public function write($sessionId, $data);
                public function destroy($sessionId);
                public function gc($maxlifetime);
            }

        }

        if (!function_exists('trait_exists')) {
            function trait_exists($class, $autoload = true) { return $autoload && class_exists($class, $autoload) && false; }
        }
        if (!function_exists('class_uses')) {
            function class_uses($class, $autoload = true)
            {
                if (is_object($class) || class_exists($class, $autoload) || interface_exists($class, false)) {
                    return array();
                }
                return false;
            }
        }
        if (!function_exists('hex2bin')) {
            function hex2bin($data) { return Polyfill\PHP54::hex2bin($data); }
        }
        if (!function_exists('session_register_shutdown')) {
            function session_register_shutdown() { register_shutdown_function('session_write_close'); }
        }
    }
}