<?php
    /**
    * Classe do carro
    */

    class Carro {
        public $id;
        public $marca;
        public $modelo;
        public $ano;

        public function save() {
            try {
                $db = json_decode(file_get_contents('./database/db.json'));

                $id = !empty($this->id) ? $this->id : $this->nextId($db->carros);
    
                $carro = [
                    'id' => $id,
                    'marca' => $this->marca,
                    'modelo' => $this->modelo,
                    'ano' => intval($this->ano),
                ];

                $db->carros[] = $carro;
                file_put_contents('./database/db.json', json_encode($db));

                return json_encode($carro);

            } catch (Exception $e) {
                return $e->getMessage();
            } catch (Error $e) {
                return $e->getMessage();
            }
        }

        public function find(int $id) {
            try {
                $db = json_decode(file_get_contents('./database/db.json'));

                $status = false;
                foreach ($db->carros as $carro) {
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
                $db = json_decode(file_get_contents('./database/db.json'));

                return json_encode($db->carros);
            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function update() {
            try {
                $db = json_decode(file_get_contents('./database/db.json'));

                foreach ($db->carros as $carro) {
                    if ($carro->id === $this->id) {
                        $carro->marca = $this->marca;
                        $carro->modelo = $this->modelo;
                        $carro->ano = intval($this->ano);

                        break;
                    }
                }

                file_put_contents('./database/db.json', json_encode($db));

                return json_encode([
                    'id' => $this->id,
                    'marca' => $this->marca,
                    'modelo' => $this->modelo,
                    'ano' => $this->ano
                ]);

            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        public function delete() {
            try {
                $db = json_decode(file_get_contents('./database/db.json'), true);

                foreach ($db['carros'] as $key => $carro) {
                    if ($carro['id'] === $this->id) {
                        array_splice($db['carros'], $key, 1);
                        break;
                    }
                }

                file_put_contents('./database/db.json', json_encode($db));

                return true;

            } catch (Exception $e) {
                return false;
            } catch (Error $e) {
                return false;
            }
        }

        private function nextId(array $table) {
            $atual = !empty($table) ? $table[count($table)-1]->id : 0;
            return $atual + 1;
        }
    }
?>