<?php


    /**
     * Classe para as regras de Validação
     * 
     * a cada nova regra de validação 'CPF, Email, Telefone...', 
     * adicionamos como um método dessa classe 
     */

    namespace Src\Validation;

    use Src\Controllers\Controller;

    class Rules
    {
        const CARRO_MAIS_ANTIGO_BRASIL = 1951;

        static function integer($nome){
            if ( !ctype_digit( strval($_REQUEST[$nome]) ) )
                Controller::returnUnprocessable("Campo $nome precisa representar um número natural!");
            
        }


        static function placa($nome)
        {
            $p = str_replace('-', '', $_REQUEST[$nome]);

            if ( strlen($p) == 7 &&
                ctype_alpha($p[0]) &&
                ctype_alpha($p[1]) &&
                ctype_alpha($p[2]) &&
                is_numeric($p[3]) &&
                (is_numeric($p[4]) || ctype_alpha($p[4])) &&
                is_numeric($p[5]) &&
                is_numeric($p[6]) ):

                $_REQUEST[$nome] = strtoupper($p[0] . $p[1] . $p[2] . '-' . $p[3] . $p[4] . $p[5] . $p[6] );
            
            else:
                Controller::returnUnprocessable("Campo $nome não é uma placa válida");
            endif;
        }

        static function anoVeiculo($nome)
        {
            self::integer($nome);

            if ( $_REQUEST[$nome] < self::CARRO_MAIS_ANTIGO_BRASIL 
                || $_REQUEST[$nome] > (new \DateTime('+1 Year'))->format('Y'))
                Controller::returnUnprocessable("Verifique o valor de $nome!");
        }


    }