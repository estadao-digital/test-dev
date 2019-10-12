<?php
//session_start(); # Absolutamente nenhum estado.
include '../app/Models/Carro.php';

class CarrosController{

    # Representa a inserção/criação. O verbo real enviado via browser é identificado no index.php
    /**
     * Na maioria dos projetos é interessante ter uma camada de serviço com um método que por exemplo insere o novo
     * carro no banco, agenda o envio de email para o gestor responsável em algum sistema de filas (redis, RabbitMQ, etc)
     * por exemplo. Como aqui não é o caso, o carregamento da model Carro será realizado aqui mesmo na camada
     * Controller.
     *
     * Também utilizaria o Swagger para ter uma interface onde fosse possível testar a API de maneira isolada,
     * independente do Front. Usei o Postman para esta tarefa.
     *
     * Não criei validações. No Laravel eu costumava criar as rules nos próprios Requests quando possível.
     *
     */
    public function post($params) {
        try{
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