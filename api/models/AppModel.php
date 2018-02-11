<?php
namespace models{

	/*
	Classe Carro
	*/
	class AppModel {
		//database attribute
		private $db;
		protected $table;
		private $sql;
		private $query;
		private $bindValues = array();

		/*
		__construct
		Set database construct
		*/
		function __construct(){
			$this->db = new \PDO('mysql:host=localhost;dbname=test-dev', 'root', ''); //connect
			$this->db->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); // enable errors to PDO
		}

		/**@function find($type, $params)
		 * @type public
		 * 
		 * @params 	string $type - 	type of return
		 * 							possible values: all or first
		 * 								all: returns multiple records
		 * 								first: returns just one record (the first one)
		 * 
		 * 			array $params -	array with parameters of a query
		 * 							possible indexes: fields, joins, conditions, group, order, limit, offset
		 * 
		 * @return 	array with data, according with $type parameter
		 * 
		 */
		public function find($type, $params = array()){
			$result = array();

			#region build query

			$this->sql  = "SELECT ";

			$this->handleFields($params);

			$this->sql .= "FROM $this->table ";

			$this->handleJoins($params);
			$this->handleConditions($params);
			$this->handleGroup($params);
			$this->handleOrder($params);
			$this->handleLimit($params);
			$this->handleOffset($params);

			#endregion
			
			// Prepare and execute query
			$this->query = $this->db->prepare($this->sql);
			$this->handleBindValue();	//use bind to prevent sql injection
			$this->query->execute();

			// Fetch and return records
			if($type == 'all'){
				$result = $this->query->fetchAll(\PDO::FETCH_ASSOC);
			} elseif($type == 'first'){
				$result = $this->query->fetch(\PDO::FETCH_ASSOC);
			}

			return $result;
			
		}

		/**@function add($values)
		 * @type public
		 * 
		 * @params 	array $values - values to save on database
		 * 
		 * @return 	bool -	true if success to save data
		 * 					false if fail to save data
		 * 
		 */
		public function add($values = array()){
			$result = array();

			#region build query
			$this->sql  = "INSERT INTO $this->table ";

			$this->handleFieldsInsert($values);
			#endregion
			
			// Prepare and execute query
			$this->query = $this->db->prepare($this->sql);
			$this->handleBindValue();	//use bind to prevent sql injection

			if($this->query->execute()) return true;
			else return false;
			
		}

		/**@function update($values, $conditions)
		 * @type public
		 * 
		 * @params 	array $values - values to update on database
		 * 			array $conditions - conditions to use on where (usually with id)
		 * 
		 * @return 	bool -	true if success to update data
		 * 					false if fail to save data
		 * 
		 */
		public function update($values = array(), $conditions = array()){
			$result = array();

			#region build query
			$this->sql  = "UPDATE $this->table SET ";

			$this->handleFieldsUpdate($values);
			
			$this->handleConditions(array('conditions'=>$conditions));
			#endregion
			
			// Prepare and execute query
			$this->query = $this->db->prepare($this->sql);
			$this->handleBindValue();	//use bind to prevent sql injection

			if($this->query->execute()) return true;
			else return false;
			
		}

		/**@function delete($conditions)
		 * @type public
		 * 
		 * @params  array $conditions - conditions to use on where
		 * 
		 * @return 	bool -	true if success to save data
		 * 					false if fail to save data
		 * 
		 */
		public function delete($conditions = array()){
			if(empty($conditions)) return false;

			#region build query
			$this->sql  = "DELETE FROM $this->table ";
			
			$this->handleConditions(array('conditions'=>$conditions));
			#endregion

			// Prepare and execute query
			$this->query = $this->db->prepare($this->sql);
			$this->handleBindValue();	//use bind to prevent sql injection

			if($this->query->execute()) return true;
			else return false;
			
		}

		/**@function handleFields($params)
		 * @type private
		 * 
		 * @params  array $params - uses only index 'fields'
		 * 
		 * Concatenate fields to use on SELECT query
		 * 
		 */
		private function handleFields($params){
			if(array_key_exists('fields', $params) && !empty($params['fields'])){
				$this->sql .= implode(', ', $params['fields']);
			}
			else{
				$this->sql .= "* "; //all fields
			}
		}

		/**@function handleFieldsInsert($values)
		 * @type private
		 * 
		 * @params  array $values 
		 * 
		 * Concatenate fields and values to use on INSERT query
		 * 
		 */
		private function handleFieldsInsert($values){
			$fields = array_keys($values);
			$this->sql .= "(".implode(', ',$fields).") VALUES(:".implode(',:',$fields).")";
			$this->bindValues = $values;
		}

		/**@function handleFieldsUpdate($values)
		 * @type private
		 * 
		 * @params  array $values 
		 * 
		 * Concatenate fields and values to use on UPDATE query
		 * 
		 */
		private function handleFieldsUpdate($values){
			foreach($values as $key => $value){
				$fields[] = " $key = :$key ";
				$this->bindValues[$key] = $value;
			}
			$this->sql .= implode(', ', $fields);
		}

		/**@function handleJoins($params) NOT IMPLEMENTED YET
		 * @type private
		 * 
		 * @params  array $params  - uses only index 'joins'
		 * 							'joins' index needs to contain: 
		 * 								- table
		 * 								- alias
		 * 								- type (INNER, LEFT, RIGHT, etc)
		 * 								- conditions
		 * 
		 * Concatenate joins to use on queries
		 * 
		 */
		private function handleJoins($params){
			if(array_key_exists('joins', $params) && !empty($params['joins'])){
				//TODO implement join, dont need for this application
			}
		}

		/**@function handleConditions($params)
		 * @type private
		 * 
		 * @params  array $params - only uses index 'conditions'
		 * 
		 * Concatenate conditions to use on SELECT, UPDATE and DELETE queries
		 * 
		 */
		private function handleConditions($params){
			if(array_key_exists('conditions', $params) && !empty($params['conditions'])){
				$this->sql .= "WHERE 1=1 ";
				foreach($params['conditions'] as $key => $condition){
					$this->sql .= "AND $key = :$key ";
					$this->bindValues[$key] = $condition;
				}
			}
		}

		/**@function handleGroup($params)
		 * @type private
		 * 
		 * @params  array $params - only uses index 'group'
		 * 
		 * Concatenate 'group by' to query
		 * 
		 */
		private function handleGroup($params){
			if(array_key_exists('group', $params) && !empty($params['group'])){
				$this->sql .= "GROUP BY ".implode(', ', $params['group'])." ";
			}
		}

		/**@function handleOrder($params)
		 * @type private
		 * 
		 * @params  array $params - only uses index 'order'
		 * 
		 * Concatenate 'order by' to query
		 * 
		 */
		private function handleOrder($params){
			if(array_key_exists('order', $params) && !empty($params['order'])){
				$this->sql .= "ORDER BY ".implode(', ', $params['order'])." ";
			}
		}

		/**@function handleLimit($params)
		 * @type private
		 * 
		 * @params  array $params - only uses index 'limit'
		 * 
		 * Concatenate 'limit' to query
		 * 
		 */
		private function handleLimit($params){
			if(array_key_exists('limit', $params) && !empty($params['limit'])){
				$this->sql .= "LIMIT ".$params['limit']." ";
			}
		}

		/**@function handleOffset($params)
		 * @type private
		 * 
		 * @params  array $params - only uses index 'offset'
		 * 
		 * Concatenate 'limit' to query
		 * Necessary to paginate results
		 * 
		 */
		private function handleOffset($params){
			if(array_key_exists('offset', $params) && !empty($params['offset'])){
				$this->sql .= "OFFSET ".$params['offset']." ";
			}
		}

		/**@function handleBindValue()
		 * @type private
		 * 
		 * After query build and prepare, call this to bind values
		 * Bind values is important to prevent sql injection
		 * 
		 */
		private function handleBindValue(){
			foreach($this->bindValues as $key => $value){
				// uses $fields declaration of every model to get its type
				switch($this->fields[$key]){
					case 'int': 
						$this->query->bindValue(':'.$key, $value, \PDO::PARAM_INT); 
						break;
					default:
						$this->query->bindValue(':'.$key, $value, \PDO::PARAM_STR);	
						break;
				} 
			}
		}

		/**@function validate()
		 * @type public
		 * 
		 * @params  array $data - data to validate
		 * 			string $type - type of validation (insert or update)
		 * 					
		 * 
		 * validate fields based on attribute $this->validations
		 * 
		 * example of $this->validate:
		 * $validations = array(
		 *		'year' => array('required', 'notEmpty')
		 *	);
		 *
		 *  example of $data:
		 * $data = array(
		 * 		'column' => 'value'
		 * );
		 * 
		 */
		public function validate($data,$type='insert'){
			$errors = [];
			foreach($this->validations as $key => $validate){
				foreach($validate as $v){ //$v: required, notEmpty, isInt
					switch($v){
						case 'required': 
							if($type=='update') break; // ignore on update
							if(!array_key_exists($key, $data)) $errors[$key] = "Campo %s é obrigatório";
							break;
						case 'notEmpty':
							if(array_key_exists($key, $data) && empty($data[$key])) $errors[$key] = "Campo %s não pode ser vazio";
							break;
						case 'isInt': 
							if(array_key_exists($key, $data) && !is_numeric($data[$key])) $errors[$key] = "Campo %s precisa ser numérico";
							break;
					}
				}
			}
			return $errors;
		}

		
        
    }
}
