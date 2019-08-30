<?php
namespace Models;

use \Core\Model;

class Carros extends Model {

	public function create($marca,$modelo,$ano)
	{
		$sql = "INSERT INTO carros(marca,modelo,ano) VALUES(:marca,:modelo,:ano)";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':marca',$marca);
		$sql->bindValue(':modelo',$modelo);
		$sql->bindValue(':ano',$ano);
		$sql->execute();
		return true;
	}

	public function getAll() {
		$array = array();

		$sql = "SELECT * FROM carros";
		$sql = $this->db->query($sql);

		if($sql->rowCount() > 0) {
			$array = $sql->fetchAll(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function getInfo($id) {
		$array = array();

		$sql = "SELECT * FROM carros WHERE id = :id";
		$sql = $this->db->prepare($sql);
		$sql->bindValue(':id',$id);
		$sql->execute();

		if($sql->rowCount() > 0) {
			$array = $sql->fetch(\PDO::FETCH_ASSOC);
		}

		return $array;
	}

	public function editInfo($id, $data)
    {
        $toChange = array();
			if(!empty($data['marca'])) {
				$toChange['marca'] = $data['marca'];
			}
			if(!empty($data['modelo'])) {
				$toChange['modelo'] = $data['modelo'];
			}
			if(!empty($data['ano'])) {
				$toChange['ano'] = $data['ano'];
			}
			if(count($toChange) > 0) {
                
				$fields = array();
				foreach($toChange as $k => $v) {
					$fields[] = $k.' = :'.$k;
				}
                
				$sql = "UPDATE carros SET ".implode(',', $fields)." WHERE id = :id";
				//echo $sql;exit;
				$sql = $this->db->prepare($sql);
				$sql->bindValue(':id', $id);

				foreach($toChange as $k => $v) {
                    $sql->bindValue(':'.$k, $v);
				}
				$sql->execute();
				if($sql->rowCount() > 0){
					return 'Dados atualizados com sucesso';
				}
        }else{
            return 'Preencha os dados corretamente';
        }
	}
	
	public function delete($id)
    {
        $sql = "DELETE FROM carros WHERE id = :id";
        $sql = $this->db->prepare($sql);
        $sql->bindValue(':id',$id);
        $sql->execute();

        return 'Carro deletado com sucesso!';
    }

}