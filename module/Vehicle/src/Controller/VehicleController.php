<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 08/12/17
 */

namespace Vehicle\Controller;


use Application\Model\Render;

use Vehicle\Entity\Brand;
use Vehicle\Entity\Vehicle;

class VehicleController extends Render
{
    public function index()
    {
        $view = 'module/Application/view/404.phtml';

        switch (count($_GET))
        {
            case 1: {
                $this->listAll();
                $view = 'module/Vehicle/view/list.phtml';
                break;
            }
        }

        $this->render($view);
    }

    public function listAll()
    {
        $this->setBd(
            array(
                'years'    => array(1980,1981,1982,1983,1984,1985,1986,1987,1988,1989,1990,1991,1992,1993,1994,1995,1996,1997,1998,1999,2000,2001,2002,2003,2004,2005,2006,2007,2008,2009,2010,2011,2012,2013,2014,2015,2016,2017,2018),
                'brands'   => $this->getEm()->getRepository('Vehicle\Entity\Brand')->findBy(array(), array('name' => 'asc')),
                'vehicles' => $this->getEm()->getRepository('Vehicle\Entity\Vehicle')->findAll()
            )
        );
    }
}