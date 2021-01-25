<?php    

    include_once 'IRequest.php';

    class Request implements IRequest {
        function __construct(){
            $this->preencheRequest();
        }

        //seta todas as keys no array $_SERVER como propriedades da classe Request
        private function preencheRequest(){
            foreach($_SERVER as $key => $value){
                $this->{$this->toCamelCase($key)} = $value;
            }
        }

        //equivalente a parameterize() do ruby
        private function toCamelCase($string){
            $result = strtolower($string);
                
            preg_match_all('/_[a-z]/', $result, $matches);

            foreach($matches[0] as $match){
                $c = str_replace('_', '', strtoupper($match));
                $result = str_replace($match, $c, $result);
            }

            return $result;
        }

        //pega o corpo(os parâmetros) da requisição
        public function getBody(){
            if($this->requestMethod === "GET"){
                return;
            }

            if ($this->requestMethod == "POST"){
            $body = array();
            $_POST = json_decode(file_get_contents("php://input"),true);
            foreach($_POST as $key => $value){
                $body[$key] = $value;
            }

            return $body;
            }
        }
    }

?>