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
     * Vehicle constructor.
     * @param $id
     * @param $model
     * @param $year
     *
     * @return void
     */
    public function __construct($id, $model, $year)
    {
        $this->id = $id;
        $this->model = $model;
        $this->year = $year;
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
     * @return string
     */
    public function setId($id)
    {
        return $this->id = $id;
    }

    /**
     * Set vehicle model
     *
     * @param string $id
     *
     * @return string
     */
    public function setModel($model)
    {
        return $this->model = $model;
    }

    /**
     * Set vehicle year
     *
     * @param string $id
     *
     * @return string
     */
    public function setYear($year)
    {
        return $this->year = $year;
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
            'year' => $this->year
        ];
    }
}
