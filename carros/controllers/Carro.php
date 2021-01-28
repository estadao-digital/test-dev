<?php
namespace controllers{

	class Carro{

		private $PDO;

		/* Conexão do BD */
		function __construct(){
			$this->PDO = new \PDO('mysql:host=localhost;dbname=api', 'root', ''); 
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); 
		}
		/* Listagem dos Carros */
		public function listCar(){
			global $app;
			$sth = $this->PDO->prepare("SELECT carro.id, marcas.marca, modelo, ano FROM carro, marcas WHERE carro.marca = marcas.id");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/* Listagem dos Carros */
		public function listBrands(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM marcas");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/* Listagem de Carro via ID */
		public function getCar($id){
			global $app;
			$sth = $this->PDO->prepare("SELECT carro.id, marcas.marca, modelo, ano FROM carro, marcas WHERE carro.id = :id AND marcas.id = carro.marca");
			$sth ->bindValue(':id',$id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/* Cadastro de um novo Carro */
		public function newCar(){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$keys = array_keys($dados); 
			
			$sth = $this->PDO->prepare("INSERT INTO carro (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
			foreach ($dados as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			$sth->execute();
			//Retorna o id inserido
			$app->render('default.php',["data"=>['id'=>$this->PDO->lastInsertId()]],200); 
		}

		/* Edição de Carro */
		public function editCar($id){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$sets = [];
			foreach ($dados as $key => $VALUES) {
				$sets[] = $key." = :".$key;
			}

			$sth = $this->PDO->prepare("UPDATE carro SET ".implode(',', $sets)." WHERE id = :id");
			$sth ->bindValue(':id',$id);
			foreach ($dados as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			//Retorna status da edição
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}

		/* Exclusão de Carro */
		public function delCar($id){
			global $app;
			$sth = $this->PDO->prepare("DELETE FROM carro WHERE id = :id");
			$sth ->bindValue(':id',$id);
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}
	}
}