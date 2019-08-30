<?php 
namespace Controllers;

use \Core\Controller;
use \Models\Carros;

class ApiController extends Controller
{
    public function index()
    {
        $method = $this->getMethod();
        $data   = $this->getRequestData();

        $carros  = new Carros;
        switch($method)
        {
            case 'GET':
                $array  = $carros->getAll();
                break;
            case 'POST':
                if(count($data) > 0)
                {   
                    $carros->create($data['marca'], $data['modelo'], $data['ano']);
                    $array['msg'] = 'Carro criado com sucesso';
                }else{
                    $array['msg'] = 'Parametros não encontrados';
                }
                break;
            default:
                $array['msg'] = 'Método '.$method.' da requisição não encontrado';
                break;
                
        }

        return $this->returnJson($array);
    }

    public function view($id)
    {
        $carros = new Carros;

        $method = $this->getMethod();
        $data   = $this->getRequestData();

        switch($method)
        {
            case 'GET':
                $array = $carros->getInfo($id);
                if(count($array) === 0 ){
                    $array['msg'] = 'Carro não encontrado';
                }
                break;
            case 'PUT':
                $array['msg'] = $carros->editInfo($id, $data);
                break;
            case 'DELETE':
                $array['msg'] = $carros->delete($id);
                break;
            default:
                $array['msg'] = 'Método '.$method.' da requisição não encontrado';
                break;
        }
        $this->returnJson($array);
    }
}