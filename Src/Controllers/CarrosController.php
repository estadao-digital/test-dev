<?php

    /**
     * Controller para Carros
     */

    namespace Src\Controllers;

    use Src\Models\Carro;

    class CarrosController extends Controller
    {

        public static function home()
        {
            // self::return( () );
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
            $carro = new Carro();
            $carro->placa = 'ABC-1D11';
            $carro->modelo = 2;
            $carro->ano = 2018;

            $id = $carro->save();

            self::returnCreated(
                ['id' => $id],
                'Carro adicionado com sucesso'
            );
        }

        public static function show($data)
        {
            $carro = new Carro();
            $carro->findById($data['id']);

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
            $carro = new Carro();
            $carro->findById($data['id']);

            if (empty($carro->id))
                self::returnNotFound('Não localizado veiculo para este ID');

            $carro->placa = 'ABC-1D11';
            $carro->modelo = 2;
            $carro->ano = 2018;

            $id = $carro->save();

            self::returnNoContent(
                ['id' => $id],
                'Carro adicionado com sucesso'
            );
        }

        public static function destroy($data)
        {
            $carro = new Carro();
            $carro->findById($data['id']);
            if (empty($carro->id))
                self::returnNotFound('Não localizado veiculo para este ID');

            $carro->destroy();
            self::returnNoContent('Veiculo removido com sucesso');
                
        }

    }