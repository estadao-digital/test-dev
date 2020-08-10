<?php

namespace App\Models;

use \JsonSerializable;
use JMS\Serializer\Annotation\AccessType;
use JMS\Serializer\Annotation\Type;
/**
 * This class Vehicle.
 */
/** @AccessType("public_method") */
class Vehicle implements JsonSerializable
{
    /**
     * @var string $id vehicle id
     * @Type("string")
     */
    private $id;

    /**
     * @var string $model vehicle model
     * @Type("string")
     */
    private $model;

    /**
     * @var int $year year of manufacture vehicle
     * @Type("int")
     */
    private $year;
    /**
     * @var string $model vehicle image in base64
     * @Type("string")
     */
    private $image;

    /**
     * Vehicle constructor.
     * @param $id
     * @param $model
     * @param $year
     * @param $image
     *
     * @return void
     */
    public function __construct($id, $model, $year, $image = null)
    {
        $this->id = $id;
        $this->model = $model;
        $this->year = $year;
        $this->image = $image;
    }

    /**
     *  Returns id vehicle
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *  Returns model vehicle
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    
    /**
     *  Returns image vehicle
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     *  Returns year of manufacture vehicle
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set vehicle id
     *
     * @param string $id
     *
     * @return void
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set vehicle model
     *
     * @param string $model
     *
     * @return void
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * Set vehicle image
     *
     * @param string $image
     *
     * @return void
     */
    public function setImage($image)
    {
        $this->image = $image;
    }    

    /**
     * Set vehicle year
     *
     * @param string $year
     *
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Customize their JSON representation
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'year' => $this->year,
            'image' => $this->image
        ];
    }
}
