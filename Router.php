<?php

    class Router
    {
        private $request;
        private $metodosHttpSuportados = array(
            "GET",
            "POST"
        );

        function __construct(IRequest $request) {
            $this->request = $request;
        }

        function __call($nome, $args) {
            list($rota, $metodo) = $args;

            if(!in_array(strtoupper($nome), $this->metodosHttpSuportados)){
                $this->trataMetodoInvalido();
            }

            $this->{strtolower($nome)}[$this->formataRota($rota)] = $metodo;
        }

        //remove / no final da rota
        private function formataRota($rota) {
            $resposta = rtrim($rota, '/');
            if ($resposta === ''){
                return '/';
            }

            return $resposta;
        }

        private function trataMetodoInvalido() {
            header("{$this->request->serverProtocol} 405 Method Not Allowed");
        }

        private function trataRequestPadrao() {
            header("{$this->request->serverProtocol} 404 Not Found");
        }

        //resolve a rota
        function resolve() {
            $tradutorDeMetodo = $this->{strtolower($this->request->requestMethod)};
            $rotaFormatada = $this->formataRota($this->request->requestUri);
            $metodo = $tradutorDeMetodo[$rotaFormatada];

            if(is_null($metodo))
            {
                $this->trataRequestPadrao();
                return;
            }

            echo call_user_func_array($metodo, array($this->request));
        }

        function __destruct() {
            $this->resolve();
        }
    }

?>
