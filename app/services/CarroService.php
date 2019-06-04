<?php

class CarroService
{
  protected $carro;

  public function __construct(Carro $carro)
  {
    $this->carro = $carro;
  }

  public function store($input)
  {
    DB::beginTransaction();

    try {
      $carro = new Carro(['marca_id' => $input['marca'], 'modelo' => $input['modelo'], 'ano' => $input['ano']]);
      $carro->save();

      DB::commit();

    } catch (\Exception $e) {

      DB::rollback();

      return $e->getMessage();
    }

  }

  public function update($id, $input)
  {

    DB::beginTransaction();

    try {

      $carro = $this->carro->find($id);

      if(isset($carro->id)) {
        $carro->update(['marca_id' => $input['marca'], 'modelo' => $input['modelo'], 'ano' => $input['ano']]);
        $carro->save();
      }

      DB::commit();

    } catch (\Exception $e) {

      DB::rollback();

      return $e->getMessage();
    }

  }

  public function destroy($id)
  {
    DB::beginTransaction();

    try {

      $carro = $this->carro->find($id);
      $carro->delete();

      DB::commit();

    } catch (\Exception $e) {

      DB::rollback();

      return $e->getMessage();
    }

  }

}
