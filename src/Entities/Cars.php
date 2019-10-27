<?php

namespace Entities;

use Abstracts\AbstractCARS;

/**
 * @Entity
 * @Table(name="Cars")
 */

class Cars extends AbstractCARS
{

    /**
     * @var integer @id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    public $id;
    
    /**
     * @var string @Column(type="string", length=50)
     */
    public $brand;

    /**
     * @var string @Column(type="string", length=50)
     */
    public $model;
    
    /**
     * @var string @Column(type="string", length=9)
     */
    public $year;

    function __construct($id = null, $brand = null, $model = null, $year = null)
    {
        $this->id       = $id;
        $this->brand    = $brand;
        $this->model    = $model;
        $this->year     = $year;
    }

    public static function construct($array)
    {
        $obj = new Cars();
        $obj->setId($array['id']);
        $obj->setBrand($array['brand']);
        $obj->setModel($array['model']);
        $obj->setYear($array['year']);
    }

    function setId($id)
    {
        $this->id = $id;
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

    function getId(){
        return $this->id;
    }

    function getBrand(){
        return $this->brand;
    }

    function getModel(){
        return $this->model;
    }

    function getYear(){
        return $this->year;
    }

    function toArray()
    {
        return [
            "id"    => $this->id,
            "brand" => $this->brand,
            "model" => $this->model,
            "year"  => $this->year
        ];
    }

}