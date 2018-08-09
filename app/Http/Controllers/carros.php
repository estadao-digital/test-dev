<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class carros extends Controller
    {



    public function home() {
        $url = asset('');
        return view('sliceTI.home', compact('url'));
    }



    public function lista() {
        $cc    = Storage::get('arquivo.json');
        $x     = json_decode($cc);
        $total = count($x);
        if ($total > 0) {
            return $cc;
        } else {
            $dados = array(
                array("id" => time(), "marca" => "fiat", "modelo" => "palio criado automaticamente", "ano" => "2017"),
            );
            $this->CriaArquivo($dados);
            $cc    = Storage::get('arquivo.json');
            return $cc;
        }
    }



    public function cadastra(Request $Request) {
        $cc    = Storage::get('arquivo.json');
        /*         * ************************************** */
        $dados = json_decode($cc);

        $vetor = array();

        $recebido['modelo'] = $Request->modelo;
        $recebido['marca']  = $Request->marca;
        $recebido['ano']    = $Request->ano;
        $recebido['id']     = time();

        $indice = -1;
        foreach ($dados as $d):
            $indice++;
            $vetor[$indice]['modelo'] = $d->modelo;
            $vetor[$indice]['marca']  = $d->marca;
            $vetor[$indice]['ano']    = $d->ano;
            $vetor[$indice]['id']     = $d->id;
        endforeach;

        $vetor[time()] = $recebido;
        Storage::put('arquivo.json', json_encode($vetor));
        echo json_encode($vetor);
    }



    public function detalhe($id) {
        $cc = Storage::get('arquivo.json');
        $x  = json_decode($cc, TRUE);
        foreach ($x as $z):
            if ($id == $z['id']) {
                return $z;
            }
        endforeach;
    }



    public function update($id, Request $Request) {
        $cc    = Storage::get('arquivo.json');
        /*         * ************************************** */
        $dados = json_decode($cc);

        $vetor = array();

        $recebido['modelo'] = $Request->modelo;
        $recebido['marca']  = $Request->marca;
        $recebido['ano']    = $Request->ano;
        $recebido['id']     = time();

        $indice = -1;
        foreach ($dados as $d):
            $indice++;
            if ($id == $d->id) {
                $recebido['modelo'] = $Request->modelo;
                $recebido['marca']  = $Request->marca;
                $recebido['ano']    = $Request->ano;
                $recebido['id']     = $id;
            } else {
                $vetor[$indice]['modelo'] = $d->modelo;
                $vetor[$indice]['marca']  = $d->marca;
                $vetor[$indice]['ano']    = $d->ano;
                $vetor[$indice]['id']     = $d->id;
            }

        endforeach;

        $vetor[time()] = $recebido;
        Storage::put('arquivo.json', json_encode($vetor));
        echo json_encode($vetor);
        
    }



    public function deleta($id, Request $Request) {
        
        $cc    = Storage::get('arquivo.json');
        /*         * ************************************** */
        $dados = json_decode($cc);

        $vetor = array();

        $indice = -1;
        foreach ($dados as $d):
            $indice++;
            if ($id == $d->id){} 
            else {
                $vetor[$indice]['modelo'] = $d->modelo;
                $vetor[$indice]['marca']  = $d->marca;
                $vetor[$indice]['ano']    = $d->ano;
                $vetor[$indice]['id']     = $d->id;
            }

        endforeach;
        Storage::put('arquivo.json', json_encode($vetor));
        echo json_encode($vetor);
    }



    private function CriaArquivo($dados = array("teste" => "info", "ee" => 2323)) {
        $dados = json_encode($dados);
        Storage::put('arquivo.json', $dados);
    }



    }
