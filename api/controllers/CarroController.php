<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/api/models/Carro.class.php");


 class CarroController 
{
    public function getCarros()
    {
        $carros = new Carro();

       return json_encode(array("sucess"=>true,'carros'=>$carros->getAll()));
    }

    public function getCarro($id)
    {
      $carros = new Carro();

      return json_encode(array("sucess"=>true,'carro'=>$carros->getCarro($id)));
    }

    public function insertCarro($request)
    {
        $carro = new Carro();

        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->marca = $request -> marca;

        if($carro->save())
        {
            return json_encode(array("sucess"=>true));
        }
        else
        {
            return json_encode(array("sucess"=>false));
        }
    }

    public function updateCarro($request,$id)
    {
        $carro = new Carro();

        $carro->modelo = $request->modelo;
        $carro->ano = $request->ano;
        $carro->marca = $request -> marca;
        $carro->id = $request->id;

        
        if($carro->update($id))
        {
            return json_encode(array("sucess"=>true));
        }
        else
        {
            return json_encode(array("sucess"=>false));
        }

    }

    public function deleteCarro($id)
    {
        $carro = new Carro();

        if($carro->delete($id))
        {
            return json_encode(array("sucess"=>true));
        }
        else
        {
            return json_encode(array("sucess"=>false));
        }
    }
}





?>