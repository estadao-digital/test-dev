<?php

    class ValidaCarro {

        public function validaMarca($marca) {

            if(empty($marca)) {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O formato da marca não é valido';

                return $retorno;

            }else {

                return false;

            }

        }

        public function validaModelo($modelo) {

            if(empty($modelo) || strlen($modelo) < 3 || is_numeric($modelo)) {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O formato do modelo não é valido';

                return $retorno;

            }else {

                return false;

            }

        }

        public function validaAno($ano) {

            if(empty($ano) || strlen($ano) < 4 || !is_numeric($ano)) {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O formato do ano não é valido';

                return $retorno;

            }else {

                return false;

            }

        }

        public function validaId($id) {

            if(empty($id) || !is_numeric($id)) {

                $retorno['status'] = 'false';
                $retorno['erro'] = 'O formato do id não é valido';

                return $retorno;

            }else {

                return false;

            }

        }
        
    }
    

?>