<?php
/**
 * Created by PhpStorm.
 * Agency: onfour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 09/12/17
 */

namespace Vehicle\VehicleModel;


use Application\Model\Module;

use Vehicle\Entity\Vehicle;
use Vehicle\Entity\Brand;

class VehicleModel extends Module
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listVehicles()
    {
        $vehicles = $this->getEm()->getRepository('Vehicle\Entity\Vehicle')->findAll();

        $arrVehicles = array();
        foreach($vehicles as $vehicle){
            $arrVehicles[] = array(
                'id' => $vehicle->getId(),
                'brand_id' => $vehicle->getBrand()->getId(),
                'brand_name' => $vehicle->getBrand()->getName(),
                'model' => $vehicle->getModel(),
                'year' => $vehicle->getYear(),
                'year_model' => $vehicle->getYearModel()
            );
        }

        return $arrVehicles;
    }

    public function saveVehicle($post)
    {
        try {
            //throw new \Exception(print_r($post));

            if(! isset($post['brand']) || isset($post['brand']) && ! is_numeric($post['brand'])){
                throw new \Exception('Selecione uma marca válida.');
            }
            if(! isset($post['model']) || isset($post['model']) && $post['model']==''){
                throw new \Exception('Digite um modelo válido.');
            }
            if(! isset($post['year']) || isset($post['year']) && ! is_numeric($post['year'])){
                throw new \Exception('Selecione o ano de fabricação.');
            }
            if(! isset($post['yearModel']) || isset($post['yearModel']) && ! is_numeric($post['yearModel'])){
                throw new \Exception('Selecione o ano modelo.');
            }

            $brand = $this->getEm()->getRepository('Vehicle\Entity\Brand')->find($post['brand']);
            if(! count($brand)){
                throw new \Exception('Selecione uma marca válida.');
            }

            if($post['edit'] == 0){
                //__construct($model, $year, $yearModel, \Vehicle\Entity\Brand $brand)
                $vehicle = new Vehicle(
                    trim($post['model']),
                    $post['year'],
                    $post['yearModel'],
                    $brand
                );
            }else{
                $vehicle = $this->getEm()->getRepository('Vehicle\Entity\Vehicle')->find($post['edit']);
                if(! count($vehicle)){
                    throw new \Exception('Veículo inválido.');
                }
                $vehicle->setBrand($brand);
                $vehicle->setModel(trim($post['model']));
                $vehicle->setYear($post['year']);
                $vehicle->setYearModel($post['yearModel']);
            }

            $this->getEm()->persist($vehicle);
            $this->getEm()->flush();

            print json_encode(['success' => true, 'vehicles' => $this->listVehicles()]);

        }catch(\Exception $e){
            print json_encode(['success' => false, 'message' => $e->getMessage()]);

        }catch(\PDOException $e){
            print json_encode(['success' => false, 'message' => $e->getMessage()]);

        }
    }

    public function getVehicle($id)
    {
        try{
            $vehicle = $this->getEm()->getRepository('Vehicle\Entity\Vehicle')->find($id);
            if(! count($vehicle)){
                throw new \Exception('Veículo inválido.');
            }

            $arrVehicle = array(
                'id' => $vehicle->getId(),
                'brand_id' => $vehicle->getBrand()->getId(),
                'brand_name' => $vehicle->getBrand()->getName(),
                'model' => $vehicle->getModel(),
                'year' => $vehicle->getYear(),
                'year_model' => $vehicle->getYearModel()
            );

            print json_encode(['success' => true, 'vehicle' => $arrVehicle]);

        }catch(\Exception $e){
            print json_encode(['success' => false, 'message' => $e->getMessage()]);

        }catch(\PDOException $e){
            print json_encode(['success' => false, 'message' => $e->getMessage()]);

        }
    }

    public function deleteVehicle($id)
    {
        try{
            $vehicle = $this->getEm()->getRepository('Vehicle\Entity\Vehicle')->find($id);
            if(! count($vehicle)) {
                throw new \Exception('Veículo inválido.');
            }

            $this->getEm()->remove($vehicle);
            $this->getEm()->flush();

            print json_encode(['success' => true]);

        }catch(\Exception $e){
            print json_encode(['success' => false, 'message' => $e->getMessage()]);

        }catch(\PDOException $e){
            print json_encode(['success' => false, 'message' => $e->getMessage()]);

        }
    }
}