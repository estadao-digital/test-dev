<?php

class CarroController extends Controller
{
	protected $carro;

	protected $service;

	public function __construct(Carro $carro, CarroService $service) {
		$this->carro = $carro;
    $this->service = $service;
  }

	public function index()
	{
		return View::make('carros.index');
	}

	public function getCarros()
	{
		$carros = Carro::all();

		foreach ($carros as $key => $carro) {
			$carro['marca_nome'] = $carro->marca->nome;
		}

		return Response::json($carros);
	}

	public function getMarcas()
	{
		$carros = Marca::all();

		return Response::json($carros);
	}

	public function findCarro($id)
	{
		$carro = Carro::withTrashed()->where('id', $id)->first();
		$carro['marca_nome'] = $carro->marca->nome;

		return Response::json($carro);
	}

	public function store()
  {
		$input = Input::all();

		$validator = CarroValidator::store($input);

		if ($validator->passes()) {

			try {
				$this->service->store($input);

				$msg = 'REGISTRO INSERIDO COM SUCESSO!';

				return $msg;

			} catch (\Exception $e) {

				return $e->getMessage();
			}
		} else {

			return $validator->errors()->first();

		}
	}

	public function update($id)
  {
		$input = Input::all();

		$validator = CarroValidator::update($id, $input);

		if ($validator->passes()) {

			try {
				$this->service->update($id, $input);

				$msg = 'REGISTRO ATUALIZADO COM SUCESSO!';

				return $msg;

			} catch (\Exception $e) {

				return $e->getMessage();
			}
		} else {

			return $validator->errors()->first();

		}
  }

	public function destroy($id)
	{
		try {

			$this->service->destroy($id);

			$msg = 'REGISTRO EXCLUIDO COM SUCESSO!';

			return $msg;

		} catch (\Exception $e) {

			return $e->getMessage();

		}
  }

}
