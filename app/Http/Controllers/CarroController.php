<?php

namespace App\Http\Controllers;

class CarroController extends Controller
{
    public function carregar_carros()
    {
        return json_decode(file_get_contents(storage_path('database.json')), true);
    }

    public function salvar_carros($carros)
    {
        file_put_contents(storage_path('database.json'), json_encode($carros));
    }

    public function carregar_carro($id)
    {
        $carros = $this->carregar_carros();
        return isset($carros[$id]) ? $carros[$id] : [];
    }

    public function validar($request)
    {
        $this->validate($request, [
            'nome'      => 'required',
            'marca'     => 'required',
            'modelo'    => 'required',
            'ano'       => 'required',
        ]);
    }

    public function adicionar_carro()
    {
        $request = request();
        $this->validar($request);

        $carros = $this->carregar_carros();

        $id = $this->auto_increment($carros);

        $carros[$id] = [
            'id'    => $id,
            'nome'  => $request->get('nome'),
            'marca' => $request->get('marca'),
            'modelo'=> $request->get('modelo'),
            'ano'   => $request->get('ano'),
        ];

        $this->salvar_carros($carros);

        return $carros;
    }

    public function editar_carro($id)
    {
        $request = request();
        $this->validar($request);

        $carros = $this->carregar_carros();

        $carros[$id] = [
            'id'    => intval($id),
            'nome'  => $request->get('nome'),
            'marca' => $request->get('marca'),
            'modelo'=> $request->get('modelo'),
            'ano'   => $request->get('ano'),
        ];

        $this->salvar_carros($carros);

        return $carros;
    }

    public function deletar_carro($id)
    {
        $carros = $this->carregar_carros();

        if(isset($carros[$id]))
        {
            $carros[$id] = null;
            $carros = array_filter($carros);
            $this->salvar_carros($carros);
        }

        return $carros;
    }

    private function auto_increment($carros)
    {
        if(count($carros)>0)
        {
            $ultimo_carro = end($carros);
            return intval($ultimo_carro['id']) + 1;
        }

        return 1;
    }
}

