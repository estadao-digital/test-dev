<?php 

namespace Cars\Car\Repositories\Eloquent;
use Cars\Car\Entities\Manufacturer as ManufacturerEntitie;

class ManufacturerRepository
{
    private $fact = null;

    public function __construct( ManufacturerEntitie $fact )
    {
        $this->fact = $fact;
    }

    public function all()
    {
        return $this->fact->all();
    }

}