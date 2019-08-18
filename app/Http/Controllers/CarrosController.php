<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrosController extends Controller {

    public function index() {

        $carros = file_get_contents(base_path('storage/app/public/carros.txt'));
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

}
