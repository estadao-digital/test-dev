<?php 

namespace Cars\Car\Repositories\Eloquent;
use Cars\Car\Entities\Car as CarEntitie;

class CarRepository
{
    private $car = null;

    public function __construct( CarEntitie $car )
    {
        $this->car = $car;
    }

    public function filterList( array $filters )
    {
        $query = $this->car->select(
                                'ca.id as car_id',
                                'ca.name as car_name',
                                'ca.model as car_model',
                                'ca.year as car_year',
                                'ca.image_location as car_image',
                                'ma.name as manufacturer_name',
                                'ma.image_location as manufacturer_image'
                                )
                        ->from('cars AS ca')
                        ->join( 'manufacturers AS ma', 'ma.id', '=', 'ca.manufacturer_id' )
                        ->where( 'ca.excluded' , '=' , '0' );
        $query = $this->addFilters( $query , $filters );
        return $query;
    }

    public function find( $identify )
    {
        return $this->car->find( $identify );
    }

    public function findBy( $field , $value )
    {
        return $this->car->where( $field , $value );
    }
    
    public function remove( $identify )
    {
        $carSave = $this->car->find($identify);
        return $carSave->fill( [ 'excluded' => '1' ] )->save();
    }
    
    public function create( $data )
    {
        return $this->car->create( $data );
    }

    public function update( $identify , $data )
    {
        $carSave = $this->car->find($identify);
        return $carSave->fill( $data )->save();
    }

    private function addFilters( $query , $filter )
    {
        if( empty( $filter ) ) return $query;
        if(!empty( $filter['name'] ))
            $query->where( 'ca.name' , 'LIKE','%'.$filter['name'].'%' );
        if(!empty( $filter['year'] ))
            $query->where( 'ca.year' , '=',$filter['year'] );
        if(!empty( $filter['manufacturer'] ))
            $query->where( 'ma.id' , '=',$filter['manufacturer'] );
        return $query;
    }
}