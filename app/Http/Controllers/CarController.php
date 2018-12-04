<?php

namespace App\Http\Controllers;

use App\Carro;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        $response = $this->responser();
        $cars = new Carro();

        if ($cars->all()) {
            $response = $this->responser(true, "Carros");
            $response['data'] = $cars->all();
        }

        if(count($cars->all())<1)
            $response = $this->responser(false,'Nada a mostrar');

        return response()->json($response);
    }

    public function show($id)
    {
        $response = $this->responser();

        $cars = new Carro();

        if ($cars->getById($id)) {
            $response = $this->responser(true, "Carro");
            $response['data'] = $cars->getById($id);
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $response = $this->responser(false,'Falha ao Criar');
        $dataValid = $this->validate($request, $this->validateRules());
        $cars = new Carro();

        if ($dataValid !== $request->post())
            $response['message'] = $dataValid;

        if ($cars->create($request->post()))
            $response = $this->responser(true, "Carro adicionado");

        return response()->json($response);
    }

    public function update(Request $request, $id)
    {
        $response = $this->responser(false,'Falaha ao Atualizar');
        $cars = new Carro();
        if ($cars->update($request->post(), $id))
            $response = $this->responser(true, "Carro atualizado");

        return response()->json($response);
    }

    public function delete($id)
    {
        $response = $this->responser(false,"Falha ao Deletar");
        $cars = new Carro();

        if ($cars->delete($id))
            $response = $this->responser(true, "Carro removido");

        return response()->json($response);
    }

    protected function validateRules()
    {
        return [
            'ano' => 'required'
            , 'modelo' => 'required'
            , 'marca' => 'required'
            , 'cor' => 'required'
        ];
    }

    protected function responser($status = false, $message = "Falha no envio")
    {
        return [
            'success' => $status
            , 'message' => $message
        ];
    }

//    protected function putNormalizer($content)
//    {
//        $data = str_replace("Content-Disposition","",$content);
//        $data = preg_replace('/:\sform-data;\sname=.+\n/','',$data);
//        $data = preg_replace('/------.+\n/','',$data);
//        $data = preg_replace('/\r\n/',',',$data);
//        $data = str_replace(",,",",",$data);
//        $data = trim($data,',');
//        $data = explode(',',$data);
//
//        return ['marca'=>$data[1],'modelo'=>$data[0],'cor'=>$data[3],'ano'=>$data[2]];
//    }
}
