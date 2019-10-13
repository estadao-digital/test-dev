<?php
//session_start(); # Absolutamente nenhum estado.
include '../app/Models/Carro.php';

class CarrosController{


    private function valida($params) {
        # Com framework a maioria das validações seriam colocadas no Request.
        $arrError = [];
        if(!isset($params['marca']) || trim($params['marca']) == '' || trim($params['marca']) == '0') {
            $arrError[] = 'A Marca deve ser selecionada!';
        }

        if(!isset($params['modelo']) || trim($params['modelo']) == '') {
            $arrError[] = 'O Modelo deve ser informado!';
        }

        if(!isset($params['ano']) || trim($params['ano']) == '') {
            $arrError[] = 'O Ano deve ser informado!';
        } elseif(!intval($params['ano'])) {
            $arrError[] = 'O Ano inválido!';
        }

        return $arrError;
    }

    # Representa a inserção/criação. O verbo real enviado via browser é identificado no index.php
    /**
     * Na maioria dos projetos é interessante ter uma camada de serviço com um método que por exemplo insere o novo
     * carro no banco, agenda o envio de email para o gestor responsável em algum sistema de filas (redis, RabbitMQ, etc)
     * por exemplo. Como aqui é apenas um teste, o carregamento da model Carro será realizado aqui na camada Controller.
     *
     * Em um ambiente real com framework seria interessante usar o Swagger para ter uma interface onde fosse possível
     * testar a API de maneira isolada, independente do Front. Usei o Postman neste caso.
     *
     */
    public function post($params) {
        try{
            $arrError = $this->valida($params);
            if(count($arrError)) {
                http_response_code(400);
                header('Content-type: application/json');
                print json_encode($arrError);
                exit();
            }

            $carro = new Carro();
            $carro->load($params);
            $carro->insert();
            http_response_code(201); # Created
        }catch(Exception $e) {
            print $e->getMessage();
        }
    }

    public function put($params) {
        try{
            $carro = new Carro();
            $carro->load($params);
            $carro->update();
            http_response_code(204); # Success No Content
        }catch(Exception $e) {
            print $e->getMessage();
        }
    }

    public function delete($params) {
        try{
            $carro = new Carro();
            $carro->load($params);
            $carro->delete();
            http_response_code(204); # Success No Content
        }catch(Exception $e) {
            print $e->getMessage();
        }
    }

    public function get($params) {
        try{
            $carro = new Carro();
            if(isset($params['id'])) {
                $carro->load($params);
                print json_encode($carro->fetch()[0]);
                exit();
            }

            foreach($carro->fetch() as $objProduto) {
                $arrProdutos[] = json_decode(json_encode($objProduto), true);
            }
            print json_encode($arrProdutos);
        }catch(Exception $e) {
            print $e->getMessage();
        }
    }

}
?>