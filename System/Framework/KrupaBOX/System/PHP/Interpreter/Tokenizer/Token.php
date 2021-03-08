<?php

namespace PHP\Interpreter\Tokenizer
{
    \Import::PHP(__KRUPA_PATH_LIBRARY__ . "Nikic/TokenStream/TokenStream.php");

    class Token extends \Token
    {
        protected $typeSid = null;

        protected static $charTokensSid = array(
            '(' => "T_OPEN_ROUND",
            ')' => "T_CLOSE_ROUND",
            '[' => "T_OPEN_SQUARE",
            ']' => "T_CLOSE_SQUARE",
            '{' => "T_OPEN_CURLY",
            '}' => "T_CLOSE_CURLY",
            ';' => "T_SEMICOLON",
            '.' => "T_DOT",
            ',' => "T_COMMA",
            '=' => "T_EQUAL",
            '<' => "T_LT",
            '>' => "T_GT",
            '+' => "T_PLUS",
            '-' => "T_MINUS",
            '*' => "T_STAR",
            '/' => "T_SLASH",
            '?' => "T_QUESTION",
            '!' => "T_EXCLAMATION",
            ':' => "T_COLON",
            '"' => "T_DOUBLE_QUOTES",
            '@' => "T_AT",
            '&' => "T_AMP",
            '%' => "T_PERCENT",
            '|' => "T_PIPE",
            '$' => "T_DOLLAR",
            '^' => "T_CARET",
            '~' => "T_TILDE",
            '`' => "T_BACKTICK",
            '\\' => "T_NS_SEPARATOR"
        );

        public function __construct($type, $content, $line)
        {
            parent::__construct($type, $content, $line);

            $this->typeSid = token_name($this->type);

            if ($this->typeSid == UNKNOWN)
                foreach(self::$charTokensSid as $content => $typeSid)
                    if ($this->content == $content)
                        $this->typeSid = $typeSid;
        }

    }
}