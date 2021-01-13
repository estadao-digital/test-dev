<?php

namespace app\lib\exception;

use Exception;

class ValidateException extends Exception {
    
    public function __construct($message, $code, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}