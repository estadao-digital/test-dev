<?
class Model
{

    private $model_items;
   

  
    private function  ReadDatabase()
    {   
    
        $db = fopen($_SERVER['DOCUMENT_ROOT']."/api/database/".$this->database.".json",'r');

        $this->model_items = json_decode(fread($db,filesize($_SERVER['DOCUMENT_ROOT']."/api/database/".$this->database.".json")));

        fclose($db);
    }

    private function SaveDatabase()
    {

        $db = fopen($_SERVER['DOCUMENT_ROOT']."/api/database/".$this->database.".json",'w');

        fwrite($db,json_encode(array_values($this->model_items)));

        fclose($db);
    }

    private function getFields()
    {
      $properties =  get_object_vars($this);
      unset($properties['model_items']);
      unset($properties['database']);

      return (object) $properties;


    }

    public function getAll()
    {
        $this->ReadDatabase();
        
        return $this->model_items;
    }
    

    public function save()
    {

        $item = $this->getFields();

        $this->ReadDatabase();

        $item->id = (int) (end($this->model_items)->id) + 1;

        $this->model_items[] = $item;
 
        $this->SaveDatabase();
 
        return $item->id;
    }

    public function get($id)
    {
        $this->ReadDatabase();

        $carro = array_reduce($this->model_items, function($accumulator, $item) use (&$id) {
         
            if($item->id == $id && empty($accumulator))
            {
               $accumulator = $item;    
            }
            return $accumulator;
        });
        
        return $accumulator;
    }

    public function delete($id)
    {
        $this->ReadDatabase();

        $rows = 0;

        for($i =0; $i < count($this->model_items);$i++)
        {
            if($this->model_items[$i]->id == $id)
            {
                unset($this->model_items[$i]);
                $rows++;
            }
        }

        $this->SaveDatabase(); 

        return $rows;
    }

    public function update($id)
    {
        $item = $this->getFields();

        $id = $id !=null? $id : $item->id;

        $this->ReadDatabase();

        $rows = 0;

        foreach($this->model_items as &$model_item){

            if($id == $model_item->id)
            {
                $model_item = $item;
                $rows += 1;
            }
        }

        $this->SaveDatabase();
    
        return $rows;
    }
}