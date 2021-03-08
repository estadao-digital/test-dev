<?php

namespace Geolocation\BR
{
    class State
    {
        public static function getStateByUF($UF)
        {
            $UF = stringEx($UF)->toLower();
            $UF = trim($UF);

            foreach (self::$states as $state)
            {
                $_UF = stringEx($state["UF"])->toLower();

                if ($UF == $_UF)
                    return stringEx($state["state"], \stringEx::ENCODING_UTF8);
            }

            return null;
        }

        public static function isValidUF($UF)
        { return self::getStateByUF($UF) != null; }

        public static function getUFByState($state)
        {
            $state = stringEx($state)->toLower(false)->remove(" ", false)->setEncoding(\stringEx::ENCODING_UTF8);
            $state = trim($state);

            foreach (self::$states as $_state)
            {
                $__state = stringEx($_state["state"])->toLower(false)->remove(" ", false)->setEncoding(\stringEx::ENCODING_UTF8);

                if ($state == $__state)
                    return $_state["UF"];
            }

            return null;
        }

        public static function isValidState($state)
        { return self::getUFByState($state) != null; }

        public static function getUFByAll($search)
        {
            $state = self::getStateByUF($search);
            return self::getUFByState(($state != null) ? $state : $search);
        }

        protected static $states =
            [
                ["UF" => "AC", "state" => "Acre"],
                ["UF" => "AL", "state" => "Alagoas"],
                ["UF" => "AM", "state" => "Amazonas"],
                ["UF" => "AP", "state" => "Amapá"],
                ["UF" => "AP", "state" => "Amapa"], // No Accent
                ["UF" => "BA", "state" => "Bahia"],
                ["UF" => "CE", "state" => "Ceará"],
                ["UF" => "CE", "state" => "Ceara"], // No Accent
                ["UF" => "DF", "state" => "Distrito Federal"],
                ["UF" => "ES", "state" => "Espírito Santo"],
                ["UF" => "ES", "state" => "Espirito Santo"], // No Accent
                ["UF" => "GO", "state" => "Goiás"],
                ["UF" => "GO", "state" => "Goias"], // No Accent
                ["UF" => "MA", "state" => "Maranhão"],
                ["UF" => "MA", "state" => "Maranhao"], // No Accent
                ["UF" => "MG", "state" => "Minas Gerais"],
                ["UF" => "MS", "state" => "Mato Grosso do Sul"],
                ["UF" => "MT", "state" => "Mato Grosso"],
                ["UF" => "PA", "state" => "Pará"],
                ["UF" => "PA", "state" => "Para"], // No Accent
                ["UF" => "PB", "state" => "Paraíba"],
                ["UF" => "PB", "state" => "Paraiba"], // No Accent
                ["UF" => "PE", "state" => "Pernambuco"],
                ["UF" => "PI", "state" => "Piauí"],
                ["UF" => "PI", "state" => "Piaui"], // No Accent
                ["UF" => "PR", "state" => "Paraná"],
                ["UF" => "PR", "state" => "Parana"], // No Accent
                ["UF" => "RJ", "state" => "Rio de Janeiro"],
                ["UF" => "RN", "state" => "Rio Grando do Norte"],
                ["UF" => "RO", "state" => "Rondônia"],
                ["UF" => "RO", "state" => "Rondonia"], // No Accent
                ["UF" => "RR", "state" => "Ronaima"],
                ["UF" => "RS", "state" => "Rio Grande do Sul"],
                ["UF" => "SC", "state" => "Santa Catarina"],
                ["UF" => "SE", "state" => "Sergipe"],
                ["UF" => "SP", "state" => "São Paulo"],
                ["UF" => "SP", "state" => "Sao Paulo"], // No Accent
                ["UF" => "TO", "state" => "Tocantins"]
            ];
    }
}