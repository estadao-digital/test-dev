<?php

namespace PHP\Interpreter
{
    \KrupaBOX\Internal\Library::load("TokenStream");

    class Tokenizer extends \TokenStream
    {
//        public function __construct($source = null)
//        {
//            if (@\function_exists("token_get_all") == false)
//            { echo json_encode(["error" => "INTERNAL_SERVER_ERROR", "message" => "Missing Tokenizer extension."]); exit; }
//
//            parent::__construct($source);
//        }

        public function indexOf($token)
        {
            for ($i = 0; $i <= count($this->tokens); $i++)
                if ($this->tokens[$i] == $token)
                    return $i;

            return null;
        }

        public function extractNamespace()
        {
            $i = 0;
            while ($i = $this->find($i, T_NAMESPACE))
            {
                $namespaceFinishId = $this->find($i, T_OPEN_CURLY);
                if ($namespaceFinishId !== 0 && $namespaceFinishId <= 0)
                    return null;

                $tokens = $this->extract($i, $namespaceFinishId);

                $namespace = "";

                foreach ($tokens as $token)
                    if ($token->is(T_STRING) || $token->is(T_NS_SEPARATOR))
                        $namespace .= $token->content;


                return Arr([
                    "namespace" => $namespace,
                    tokenizer => $tokens
                ]);
            }
        }

        public function extractClass()
        {
            $i = 0;
            while ($i = $this->find($i, T_CLASS))
            {
                $classFinishId = $this->find($i, T_OPEN_CURLY);
                if ($classFinishId !== 0 && $classFinishId <= 0)
                    return null;

                $tokens = $this->extract($i, $classFinishId);
                $className = "";

                foreach ($tokens as $token)
                    if ($token->is(T_STRING))
                    { $className = $token->content; break; }


                return Arr([
                    "class" => $className,
                    tokenizer => $tokens
                ]);
            }
        }
    
    }
}