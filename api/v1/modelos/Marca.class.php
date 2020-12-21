<?php

require_once 'api/v1/helpers/JsonDBHelper.php';

final class Marca
{
    const TABELA = 'marcas';
    public $ID;
    public $Marca;

    //Devolvendo os objetos em json
    public function __toString() {
        return json_encode($this);

    }

    //Devolve o objeto do tipo Marca por ID vindo do Banco
    public static function pegaMarcaPorId(int $id){
        $registro = pegaRegistroPorID(Marca::TABELA, $id);
        if (!is_null($registro)) {
            $marca = new Marca();
            $marca->ID = $registro['ID'];
            $marca->Marca = $registro['Marca'];
            return $marca;
        }
        return null;
    }

    //Devolve todas as marcas do banco como Objetos do tipo Marca
    public static function pegaMarcas(){
        $registros = leTabela(Marca::TABELA);
        $marcas = [];
        foreach ($registros as $registro) {
            $marca = new Marca();
            $marca->ID = $registro['ID'];
            $marca->Marca = $registro['Marca'];
            array_push($marcas, $marca);
        }
        return $marcas;
    }

    public function toArray(){
        return [
            'ID'        => $this->ID,
            'Marca'     => $this->Marca,
        ];
    }

    public static function deleta($id){
        deletaRegistro(Marca::TABELA, $id);
    }

    //Salva criando um novo registro ou atualizando um antigo via ID
    public function salva(){
        if($this->ID){
            //atualiza registro
            modificaRegistro(Marca::TABELA, $this->toArray(), $this->ID);
        }else{
            //Cria um novo registro
            $this->ID = adicionaRegistro(Marca::TABELA, $this->toArray());
        }
        return $this;
    }

}