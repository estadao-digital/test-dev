<?php

namespace Entities;

/**
 * @Entity
 * @Table(name="Cars")
 */

class Cars 
{

    /**
     * @var integer @id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @var string @Column(type="string", length=50)
     */
    private $brand;

    /**
     * @var string @Column(type="string", length=50)
     */
    private $model;
    
    /**
     * @var string @Column(type="string", length=9)
     */
    private $year;

    function __construct($id = null, $brand = null, $model = null, $year = null)
    {
        $this->id       = $id;
        $this->brand    = $brand;
        $this->model    = $model;
        $this->year     = $year;
    }

    function setBrand($brand)
    {
        $this->brand = $brand;
    }

    function setModel($model)
    {
        $this->model = $model;
    }

    function setYear($year)
    {
        $this->year = $year;
    }

}