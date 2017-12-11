<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

namespace Vehicle\Entity;

use Vehicle\Entity\Brand;

/**
 * @Entity
 * @Table(name="vehicle")
 */
class Vehicle
{
    /**
     * @var integer
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", nullable=false)
     */
    private $model;

    /**
     * @var int
     * @Column(type="integer", nullable=false)
     */
    private $year;

    /**
     * @var int
     * @Column(type="integer", nullable=false)
     */
    private $yearModel;

    /**
     * @var \Vehicle\Entity\Brand
     * @ManyToOne(targetEntity="\Vehicle\Entity\Brand", inversedBy="vehicles")
     */
    private $brand;

    /**
     * Vehicle constructor.
     * @param string $model
     * @param int $year
     * @param int $yearModel
     * @param \Vehicle\Entity\Brand $brand
     */
    public function __construct($model, $year, $yearModel, \Vehicle\Entity\Brand $brand)
    {
        $this->model = $model;
        $this->year = $year;
        $this->yearModel = $yearModel;
        $this->brand = $brand;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param int $year
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * @return int
     */
    public function getYearModel()
    {
        return $this->yearModel;
    }

    /**
     * @param int $yearModel
     */
    public function setYearModel($yearModel)
    {
        $this->yearModel = $yearModel;
    }

    /**
     * @return \Vehicle\Entity\Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * @param \Vehicle\Entity\Brand $brand
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    }
}