<?php

namespace app\Http\Controllers\Carro;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Carro\Carro;


class CarroController extends Controller
{

    private $carro;
    private $request;



    public function __construct(Carro $carro, Request $request)
    {


        $this->carro = $carro;
        $this->request = $request;


    }

    public function index()
    {
        $carros = $this->carro->get();

        return view('welcome', compact('carros'));
    }

    public function show($id)
    {
        $carro = $this->carro->find($id);

        return Response::json($carro);
    }



    public function create(Request $request)
    {
        $carro = $this->carro->create($request->all());


        return Response::json($carro);
    }

    public function update(Request $request, $id)
    {
        $carro = $this->carro->find($id);

        $carro->carro = $request->carro;
        $carro->cor = $request->cor;

        $carro->save();

        return Response::json($carro);
    }


    public function destroy($id)
    {
        $carro = carro::destroy($id);

        return Response::json($carro);
    }


}
