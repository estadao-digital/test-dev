<?php

namespace App\Http\Controllers;

use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{
    /**
     * @var MarcaRepository
     */
    private $marcaRepository;

    /**
     * MarcaController constructor.
     */
    public function __construct(MarcaRepository $marcaRepository)
    {
        $this->marcaRepository = $marcaRepository;
    }

    public function index(){
        return $this->marcaRepository->all();
    }


}
