<?php

namespace App\Services;

use App\Repositories\CarRepository;
use App\Validators\CarValidator;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class CarService
{
    /**
     * @var CarRepository
     */
    private $repository;

    /**
     * @var CarValidator
     */
    private $validator;     

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(CarRepository $repository, CarValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * List All cars to database.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->with('brand')->all();
    }

    /**
     * Selected data
     * @param  integer $id 
     * @return object 
     */
    public function show($id)
    {
        $car = $this->repository->with('brand')->find($id);

        return [
            'success' => true,
            'message' => 'Carro selecionado com sucesso.',
            'data'    => $car,
        ];
    }

    /**
     * Save request data
     * @param  array  $data request
     * @return array result
     */
    public function store(array $attributes)
    {
        try {
            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);

            $car = $this->repository->create($attributes);
            $car = $this->repository->with('brand')->find($car->id);

            return [
                'success' => true,
                'message' => 'Carro cadastrado com sucesso.',
                'data'    => $car,
            ];
        } catch (ValidatorException $e) {
            return [
                'success' => false,
                'message' => 'Erro de execução',
                'data'    => $e->getMessageBag()
            ];
        }
    }

    /**
     * Update request database
     * @param  array  $data request form
     * @param  integer $id
     * @return array result
     */
    public function update(array $attributes, $id)
    {      
        try {
            $this->validator->with($attributes)->passesOrFail(ValidatorInterface::RULE_CREATE);
 
            $car = $this->repository->with('brand')->find($id);
            $car->update($attributes);

            return [
                'success' => true,
                'message' => 'Carro alterado com sucesso.',
                'data'    => $car,
            ];
        } catch (ValidatorException $e) {
            return [
                'success' => false,
                'message' => 'Erro de execução',
                'data'    => $e->getMessageBag()
            ];
        }
    }

    /**
     * Remove request database
     * @param  integer $id
     * @return array result
     */
    public function destroy($id)
    {        
        $car = $this->repository->with('brand')->find($id);
        $car->delete($id);

        return [
            'success' => true,
            'message' => 'Carro removido com sucesso.',
            'data'    => $car,
        ];
    }
}