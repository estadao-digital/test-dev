<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

namespace Vehicle\Entity;

use Vehicle\Entity\Vehicle;

/**
 * @Entity
 * @Table(name="brand")
 */
class Brand
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
    private $name;

    /**
     * @var \Vehicle\Entity\Vehicle[]
     * @OneToMany(targetEntity="\Vehicle\Entity\Vehicle", mappedBy="brand")
     */
    private $vehicles;

    /**
     * Brand constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return \Vehicle\Entity\Vehicle[]
     */
    public function getVehicles()
    {
        return $this->vehicles;
    }

    /**
     * @param \Vehicle\Entity\Vehicle[] $vehicles
     */
    public function setVehicles($vehicles)
    {
        $this->vehicles = $vehicles;
    }
}