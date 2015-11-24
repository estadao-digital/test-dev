<?php

class Carros{
    
    public function __construct(){
        
    }
    public function add(){
    
        
    }
    
    public function index($id = null){
        
        $req = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
        

        if(method_exists($this, $id)){
            return $this->$id();
        }
        if($req == 'DELETE'){
            return $this->delete($id);
        }
        
        if($req == 'POST'){
            return $this->create();
        }
        if($req == 'PUT'){
            return $this->update($id);
        }
        
        $car_list = CarrosModel::all();
        require_once APP_DIR . '/views/carros.php';
    }
    
    
    public function delete($id){
        header('Content-type: application/json');
        if(empty($id)){
            return json_encode([
                'sucess'=>false,
                'message'=>'UM ID deve ser informado'
            ]);
        }
        
        $carro = CarrosModel::find($id);
        $carro->delete();
        
        try{
            return json_encode([
                'success'=>true,
                'message'=>'CARRO: '.$id . ' removido com sucesso'
            ]);
        }catch(\Exception $e){
            return json_encode([
                'success'=>false,
                'message'=>'Carro nao existe na base'
            ]);
        }
        
    }
    
    public function create(){
        header('Content-type: application/json');
        
        $m = new CarrosModel;
        $m->marca = $_POST['marca'];
        $m->modelo = $_POST['modelo'];
        $m->ano = $_POST['ano'];
        
        
        try{
            $m->save();
        }catch(\Exception $e){
            return json_encode([
                'success'=>false,
                'message'=>'Ocorreu um erro ao salvar os dados'
            ]);
        }
        $id = $m->id;
        return json_encode([
                'success'=>true,
                'message'=>'CARRO: '.$id . 'criado com sucesso'
            ]);
        
    }
    
    public function update($id){
        header('Content-type: application/json');
        
        $m = CarrosModel::find($id);
        $data = file_get_contents('php://input');
        parse_str($data, $data);
        
        
        $m->marca = $data['marca'];
        $m->modelo = $data['modelo'];
        $m->ano = $data['ano'];
        try{
            $m->save();
        }catch(\Exception $e){
            return json_encode([
                'sucess'=>false,
                'message'=>'Ocorreu um erro ao salvar os dados'
            ]);
        }
        return json_encode([
                'sucess'=>true,
                'message'=>'CARRO: '.$id . 'atualizado com sucesso.'
            ]);
        
    }
    
    public function listCars(){
        $carros = CarrosModel::all();
        $html = '';
        ob_start();
        foreach($carros as $carro){?> 
            <tr data-id="<?php echo $carro->id; ?>">
                                                    <td><?php echo $carro->id; ?></td>
                                                    <td><?php echo $carro->marca; ?></td>
                                                    <td><?php echo $carro->modelo; ?></td>
                                                    <td><?php echo $carro->ano; ?></td>
                                                    <td>
                                                        <a href="javascript:void(0);" onclick="removeCar(<?php echo $carro->id; ?>)"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> |  <a href="javascript:void(0);" onclick="showEditForm(this)" data-id='<?php echo $carro->id ?>' data-marca='<?php echo $carro->marca ?>' data-modelo='<?php echo $carro->modelo ?>' data-ano='<?php echo $carro->ano ?>'><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                                                    </td>
                                                </tr>
                                                    <?php
                                                    
        }
        $html = ob_get_contents();
                                                    
                                                    ob_end_clean();
                                                    
                                                    
                                                    return $html;
    }
    
    
    
}