<?php

namespace Cars\Car\Services;
use Cars\Car\Validators\CarValidator;
use Cars\Car\Exceptions\CarEditException;
use Cars\Car\Entities\Car;
use Cars\Car\Repositories\Eloquent\CarRepository;
use Cars\Car\Repositories\Eloquent\ManufacturerRepository;

class CarService
{
    private $carRepo = null;
    
    public function __construct()
    {
        $this->carRepo = new CarRepository( new Car() );
    }

    public function getFilterList( array $filter )
    {
        return $this->carRepo->filterList( $filter )->get();
    }

    public function remove( $identify )
    {
        return $this->carRepo->remove( $identify );
    }

    public function create( array $data )
    {
        $validate = new CarValidator();
        $validation = $validate->validateCreate( $data );
        if( $validation->fails() )
            throw new CarEditException( implode( "\n" , $validation->errors()->all() ) );
        return $this->carRepo->create( $data );
    }

    public function update( $identify , array $data )
    {
        $validate = new CarValidator();
        $validation = $validate->validateUpdate( $data );
        if( $validation->fails() )
            throw new CarEditException( implode( "\n" , $validation->errors()->all() ) );
        return $this->carRepo->update( $identify , $data );
    }

    public function edit( $identify )
    {
        $edit = $this->find( $identify );
        unset( $edit['created_at'], $edit['updated_at'] );
        return $edit;
    }

    public function find( $identify )
    {
        return $this->carRepo->find( $identify );
    }

    public function findBy( $field )
    {
        return $this->carRepo->findBy( $field )->first();
    }

    public function getAllManufacturer()
    {
        $manu = new ManufacturerRepository( new \Cars\Car\Entities\Manufacturer() );
        return $manu->all();
    }

}