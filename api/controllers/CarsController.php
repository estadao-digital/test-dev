<?php
namespace controllers{
    /*
	Class CarrosController
    */
    class CarsController extends AppController{
        private $car;

        function __construct(){
            parent::__construct();
            //instantiate car model
            $this->car = new \models\Car();
        }

		function getCars() {
            $cars = $this->car->find('all',array('order' => array('brand_name','model','year DESC')));

            // return json with data or an error message
            if(!empty($cars)) return $this->render(array('data'=>$cars));
            else return $this->render(array('message'=>'Nenhum carro encontrado'));
        }

        function getBrands() {
            $brands = $this->car->find('all',array('fields'=>array('brand_name'),'group'=>array('brand_name')));

            // return json with data or an error message
            if(!empty($brands)) return $this->render(array('data'=>$brands));
            else return $this->render(array('message'=>'Nenhuma marca encontrada'));
        }

        function getCar($id) {
            $car = $this->car->find('first',array('conditions'=>array('id'=>$id)));

            // return json with data or an error message
            if(!empty($car)) return $this->render(array('data'=>$car));
            else return $this->render(array('message'=>'Carro não encontrado'));
        }

        function addCar($data) {
            #region Validations

            //validate fields
            $errors = $this->car->validate($data);
            if(!empty($errors)){
                return $this->render(array('status'=>501,'message'=>'Erro ao adicionar o carro', 'errors' =>$errors));
            }
            
            //verify if car exists
            $car = $this->exists($data);
            if($car) return $this->render(array('status'=>501,'message'=>'Erro ao adicionar o carro', 'errors' =>array("Carro já cadastrado")));
            
            #endregion

            //insert values
            if($this->car->add($data)){
                return $this->render(array('status'=>201, 'message'=>'Carro adicionado com sucesso', 'data'=>$data));
            } else{
                return $this->render(array('status'=>501,'message'=>'Erro ao adicionar o carro'));
            }
        }

        function updateCar($id, $data) {
            //validate fields
            $errors = $this->car->validate($data,'update');
            if(!empty($errors)){
                return $this->render(array('status'=>501,'message'=>'Erro ao adicionar o carro', 'errors' =>$errors));
            }

            //verify if car exists
            $car = $this->exists($data, $id);
            if($car) return $this->render(array('status'=>501,'message'=>'Erro ao adicionar o carro', 'errors' =>array("Carro já cadastrado")));

            //update values
            if($this->car->update($data, array('id'=>$id))){
                return $this->render(array('status'=>201, 'message'=>'Carro editado com sucesso','data'=>$data));
            } else{
                return $this->render(array('status'=>501,'message'=>'Erro ao atualizar o carro'));
            }
        }

        function deleteCar($id) {
            if($this->car->delete(array('id'=>$id))) {
                return $this->render(array('status'=>201, 'message'=>'Carro removido com sucesso'));
            } else{
                return $this->render(array('status'=>501,'message'=>'Erro ao remover o carro'));
            }
        }

        function exists($data, $id=null){
            $car = $this->car->find('first',array('conditions'=>$data));
            if(!empty($id)){
                if($car['id'] == $id) return false; //prevent to display error to the same register
            }
             //verify if car exists
             if(!empty($car)) return $car;
             else return false;
        }
        
    }
}
