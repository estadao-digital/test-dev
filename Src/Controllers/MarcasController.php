<?php

    /**
     * Controller para Marcas
     */

    namespace Src\Controllers;

    use Src\Models\Marca;

    class MarcasController extends Controller
    {
        public static function index(){
            
            $marca = new Marca;
            
            self::returnOk(
                $marca->getAll(),
                'Busca por Marcas'
            );
        }
    }