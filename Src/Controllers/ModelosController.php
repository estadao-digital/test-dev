<?php

    /**
     * Controller para Modelos
     */

    namespace Src\Controllers;

    use Src\Models\Modelo;

    class ModelosController extends Controller
    {
        public static function index()
        {
            $modelo = new Modelo;

            self::returnOk(
                $modelo->getAll(),
                'Busca por Marcas'
            );
        }

        public static function show($data)
        {
            $marca_id = $data['marca_id'];
            
            self::returnOk(
                (new Modelo)->getByMarca($marca_id),
                'Modelos de uma Marca'
            );


        }
    }