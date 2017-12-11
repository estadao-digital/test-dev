<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

namespace Application\Model;


use Registry\Registry;

class Module
{
    protected $em;
    protected $bd;

    public function __construct()
    {
        $this->setEm(Registry::resolve("entityManager"));
    }

    /**
     * @param mixed $bd
     */
    public function setBd($bd)
    {
        $this->bd = $bd;
    }

    /**
     * @return mixed
     */
    public function getBd()
    {
        return $this->bd;
    }

    /**
     * @param mixed $em
     */
    public function setEm($em)
    {
        $this->em = $em;
    }

    /**
     * @return mixed
     */
    public function getEm()
    {
        return $this->em;
    }
}