<?php
    /**
    * Classe do carro
    */

    class Carro {
        public $id;
        public $marca;
        public $modelo;
        public $ano;

        protected $db;

        public function __construct () {

        }

        public function save() {
            try {
                $this->db = json_decode(file_get_contents('./database/db.json'));

                $id = !empty($this->id) ? $this->id : $this->nextId($this->db->carros);
    
                $this->db->carros[] = [
                    'id' => $id,
                    'marca' => $this->marca,
                    'modelo' => $this->modelo,
                    'ano' => intval($this->ano),
                ];
    
                file_put_contents('./database/db.json', json_encode($this->db));

                return true;

            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function find(int $id) {
            try {
                $this->db = json_decode(file_get_contents('./database/db.json'));

                $status = false;
                foreach ($this->db->carros as $carro) {
                    if ($carro->id === $id) {
                        $this->id = $carro->id;
                        $this->marca = $carro->marca;
                        $this->modelo = $carro->modelo;
                        $this->ano = $carro->ano;

                        $status = true;
                        break;
                    }
                }
                
                return $status;

            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function get(int $id) {
            try {
                if ($this->find($id)) {
                    return json_encode([
                        'id' => $this->id,
                        'marca' => $this->marca,
                        'modelo' => $this->modelo,
                        'ano' => $this->ano
                    ]);
                } else {
                    return 'nao_encontrado';
                }
            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function getAll() {
            try {
                $this->db = json_decode(file_get_contents('./database/db.json'));

                return json_encode($this->db->carros);
            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function update() {
            try {
                $this->db = json_decode(file_get_contents('./database/db.json'));

                foreach ($this->db->carros as $carro) {
                    if ($carro->id === $this->id) {
                        $carro->marca = $this->marca;
                        $carro->modelo = $this->modelo;
                        $carro->ano = intval($this->ano);

                        break;
                    }
                }

                file_put_contents('./database/db.json', json_encode($this->db));

                return true;

            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function delete() {
            try {
                $this->db = json_decode(file_get_contents('./database/db.json'));

                foreach ($this->db->carros as $key => $carro) {
                    if ($carro->id === $this->id) {
                        unset($this->db->carros[$key]);

                        break;
                    }
                }

                file_put_contents('./database/db.json', json_encode($this->db));

                return true;

            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        private function nextId(array $table) {
            return $table[count($table)-1]->id + 1;
        }
    }
?>