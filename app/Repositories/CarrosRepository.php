<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 25/10/19
 * Time: 14:31
 */

namespace App\Repositories;
use Mockery\Exception;

class CarrosRepository
{
    private $bancoDados;
    private $caminhoArquivo;
    public function __construct()
    {
        $this->caminhoArquivo = $dbFilePath = '../cars.json';
        $this->bancoDados = json_decode(file_get_contents('../cars.json'),true);
    }

    public function all()
    {
        try {
            $carros = $collection = $this->bancoDados;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $carros;
    }

    public function find($id)
    {
        try {
            $indexConsulta = 0;
            foreach ($this->bancoDados as $index => $carro) {
                if(array_key_exists('id',$carro)) {
                    if($carro['id'] == $id) {
                        $indexConsulta = $index;
                        break;
                    }
                }
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

        return $this->bancoDados[$indexConsulta];
    }

    public function store(array $data)
    {
        try {
            $maxId = array_reduce($this->bancoDados,function ($inicio,$array) {
                if(array_key_exists('id',$array))
                    if($array['id'] > $inicio) $inicio = $array['id'];

                return $inicio;
            },0);

            $this->bancoDados[] = [
                'id' => $maxId + 1,
                'modelo' => $data['modelo'],
                'marca' => $data['marca'],
                'ano' => $data['ano']
            ];
            file_put_contents($this->caminhoArquivo, json_encode($this->bancoDados));
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
        return collect(last($this->bancoDados));
    }

    public function update(array $data, $id)
    {
        try {
            $indexEditar = 0;
            try {
                foreach ($this->bancoDados as $index => $carro) {
                    if($carro['id'] == $id) {
                        $indexEditar = $index;
                        break;
                    }
                }

                if(!is_null($indexEditar)) {
                    $this->bancoDados[$indexEditar]['modelo'] = $data['modelo'];
                    $this->bancoDados[$indexEditar]['marca'] = $data['marca'];
                    $this->bancoDados[$indexEditar]['ano'] = $data['ano'];
                }

                file_put_contents($this->caminhoArquivo, json_encode($this->bancoDados));
            } catch (\Exception $e) {
                throw new Exception($e->getMessage());
            }
            return $this->bancoDados[$indexEditar];

        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        $idDeletar = 0;
        try {
            foreach ($this->bancoDados as $index => $carro) {
                if($carro['id'] == $id) {
                    $idDeletar = $index;
                    break;
                }
            }

            $carro = $this->bancoDados[$idDeletar];
            unset($this->bancoDados[$idDeletar]);
            file_put_contents($this->caminhoArquivo, json_encode($this->bancoDados));
        } catch (\Exception $e) {
            throw new Exception($e->getMessage());
        }
        return $carro;
    }
}