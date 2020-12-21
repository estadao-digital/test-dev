<?php

require_once 'api/v1/helpers/JsonDBHelper.php';

final class Carro
{
    const TABELA = 'carros';
    public $ID;
    public $Marca;
    public $Modelo;
    public $Ano;

    //Devolvendo os objetos em json
    public function __toString() {
        return json_encode($this);

    }

    //Devolve o objeto do tipo carro por ID vindo do Banco
    public static function pegaCarroPorId(int $id){
        $registro = pegaRegistroPorID(Carro::TABELA, $id);
        if (!is_null($registro)) {
            $carro = new Carro();
            $carro->ID = $registro['ID'];
            $carro->Marca = $registro['Marca'];
            $carro->Modelo = $registro['Modelo'];
            $carro->Ano = $registro['Ano'];
            return $carro;
        }
        return null;
    }

    //Devolve todos os carros do banco como Objetos do tipo Carro
    public static function pegaCarros(){
        $registros = leTabela(Carro::TABELA);
        $carros = [];
        foreach ($registros as $registro) {
            $carro = new Carro();
            $carro->ID = $registro['ID'];
            $carro->Marca = $registro['Marca'];
            $carro->Modelo = $registro['Modelo'];
            $carro->Ano = $registro['Ano'];
            array_push($carros, $carro);
        }
        return $carros;
    }

    public static function deleta($id){
        deletaRegistro(Carro::TABELA, $id);
    }

    public function toArray(){
        return [
            'ID'        => $this->ID,
            'Marca'     => $this->Marca,
            'Modelo'    => $this->Modelo,
            'Ano'       => $this->Ano
        ];
    }

    //Salva criando um novo registro ou atualizando um antigo via ID
    public function salva(){
        if($this->ID){
            //atualiza registro
            modificaRegistro(Carro::TABELA, $this->toArray(), $this->ID);
        }else{
            //Cria um novo registro
            $this->ID = adicionaRegistro(Carro::TABELA, $this->toArray());
        }
        return $this;
    }

}