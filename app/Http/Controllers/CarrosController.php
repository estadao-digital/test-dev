<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrosController extends Controller {

    public function index() {

        //$carros = file_get_contents(base_path('storage/app/public/carros.txt'));
        $file = fopen(base_path('storage/app/public/carros.txt'), 'r');
        $carros = array();
        while (!feof($file)) {
            $linha = fgets($file, 1024);
            if(empty($linha)){
                continue;
            }else{
                $carros[] = $linha;
            }
        }
        
        return response()->json([
                    'status' => 'ok',
                    'data' => $carros
                        ], 200);
    }

    public function buscarVeiculo($id) {
        $carros = fopen(base_path('storage/app/public/carros.txt'), 'r');
        $pBusca = null;
        while (!feof($carros)) {
            $linha = fgets($carros, 1024);
            $registro = explode(',', $linha);
            if ($registro[0] === $id) {
                $pBusca = $linha;
                break;
            }
        }
        fclose($carros);
        if (!empty($pBusca)) {
            return response()->json([
            'status' => 'ok',
            'data' => $pBusca
            ]);
        }
        return response()->json([
                    'status' => 'ok',
                    'message' => 'Registro não encontrado!'
        ],200);
    }

    public function cadastrarVeiculo(Request $request) {

        $dados = $request['id'] . ',' . $request['marca'] . ',' . $request['modelo'] . ',' . $request['ano'] . "\n";
        file_put_contents(base_path('storage/app/public/carros.txt'), $dados, FILE_APPEND);
        return $this->index();
    }

    public function atualizarVeiculo($id, Request $request) {
        
        $novosDados = $request['id'] . ',' . $request['marca'] . ',' . $request['modelo'] . ',' . $request['ano'] . "\n";
        
        $dadosAtuais = null;
        $file = base_path('storage/app/public/carros.txt');
        $carros = fopen($file, 'r');

        while (!feof($carros)) {
            $linha = fgets($carros, 1024);

            $registro = explode(',', $linha);
            if ($registro[0] === $id) {
                $dadosAtuais .= $novosDados;
            } else {
                $dadosAtuais .= $linha;
            }
        }
        fclose($carros);
        file_put_contents($file, $dadosAtuais);
        return $this->index();
    }

    public function deletarVeiculo($id) {
        $file = base_path('storage/app/public/carros.txt');
        $carros = fopen($file, 'r');
        $dadosAtuais = null;
        while (!feof($carros)) {
            $linha = fgets($carros, 1024);

            $registro = explode(',', $linha);
            if ($registro[0] === $id) {
                continue;
            } else {
                $dadosAtuais .= $linha;
            }
        }
        fclose($carros);
        file_put_contents($file, $dadosAtuais);
        return $this->index();
    }
    
    public function edit($id){
        $marcas = array(
            array('marca'=>'GM','nome'=>'GM'),
            array('marca'=>'Fiat','nome' =>'Fiat'),
            array('marca'=> 'VW','nome'=>'Volksvagem'),
            array('marca'=>'FORD','nome'=>'FORD')
            );
        $response = $this->buscarVeiculo($id);
        $dados = $response->getData()->data;
        $dados = explode(',',preg_replace("/\r?\n/","", $dados));
        
        $carro['id'] = $dados[0];
        $carro['marca'] = $dados[1];
        $carro['modelo'] = $dados[2];
        $carro['ano'] = $dados[3];
        
        
        return view('editar',[
            'carro' => $carro,
            'marcas' => $marcas
        ]);
    }

}
