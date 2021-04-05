<?php

    /**
     * Controller para Carros
     */

    namespace Src\Controllers;

    use Src\Models\Carro;
    use Src\Validation\Validation;

    class CarrosController extends Controller
    {

        public static function home()
        {
            require 'Public/template.php';
        }


        public static function index(){
            $carro = new Carro();
            
            self::returnOk(
                $carro->getAll(), 
                'Lista de Veículos'
            );

        }


        public static function store()
        {
            $_REQUEST = (array) json_decode(file_get_contents("php://input") );
            
            $carro = new Carro();
            $carro->placa       = Validation::request('placa', ['placa']);
            $carro->modelo_id   = Validation::request('modelo_id', ['integer']);
            $carro->ano         = Validation::request('ano', ['anoVeiculo']);
    
            $id = $carro->save();
            if($carro->fail()){
                echo $carro->fail()->getMessage();
            }

            self::returnCreated(
                ['id' => $id],
                'Carro adicionado com sucesso'
            );
        }


        public static function show($data)
        {
            $carro = (new Carro())->findById($data['id']);

            if (empty($carro->id))
                self::returnNotFound('Não localizado veiculo para este ID');
            else
                self::returnOk(
                    $carro->data(),
                    'Dados do Veículo'
                );  
        }


        public static function edit($data)
        {
            $_REQUEST = (array) json_decode(file_get_contents("php://input") );
            
            $carro = (new Carro())->findById($data['id']);

            if (empty($carro->id))
                self::returnNotFound('Não localizado veiculo para este ID');

            $carro->placa   = Validation::request('placa', ['placa']);
            $carro->modelo_id  = Validation::request('modelo_id', ['integer']);
            $carro->ano     = Validation::request('ano', ['anoVeiculo']);

            $carro->save();
            if($carro->fail()){
                echo $carro->fail()->getMessage();
            }

            self::returnNoContent(
                'Carro aterado com sucesso'
            );
        }


        public static function destroy($data)
        {
            
            $carro = (new Carro())->findById($data['id']);
            
            if (empty($carro->id))
                self::returnNotFound('Não localizado veiculo para este ID');

            $carro->destroy();
            self::returnNoContent('Veiculo removido com sucesso');
                
        }

    }