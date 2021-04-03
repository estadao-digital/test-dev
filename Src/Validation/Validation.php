<?php


    /**
     * Classe para validação de inputs
     */


    namespace Src\Validation;


    class Validation extends Rules
    {
        /**
         * Pega o parametro em $_REQUEST e faz todas as validações nele
         * 
         * @param nome, nome do campo, chave no $_REQUEST
         * @param rules, array com todas as regras que deverão ser aplicadas
         * @param default, caso não existe, retornar esse valor, $default não pode ser Null
         * 
         * @return value caso este seja aprovado pelas validações
         */
        static function request(string $nome, array $rules = [])
        {

            foreach( $rules as $rule)
                static::$rule($nome);

            return $_REQUEST[$nome];

        }
    }