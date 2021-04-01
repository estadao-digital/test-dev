<?php

namespace App\Http\Controllers;

use App\Repositories\CarroRepository;
use Illuminate\Http\Request;

class CarroController extends Controller
{
    /**
     * @var CarroRepository
     */
    private $carroRepository;

    /**
     * CarroController constructor.
     */
    public function __construct(CarroRepository $carroRepository)
    {
        $this->carroRepository = $carroRepository;
    }

    public function index(){
        return $this->carroRepository->all();
    }

    public function store(Request $request){
        $this->validate($request, $this->getRequest($request));
       return $this->carroRepository->create($request->all());
    }

    public function update(Request $request,$id){
        $this->validate($request, [
            'marca' => 'required',
            'modelo' => 'required',
            'ano' => 'required',
        ]);
        return $this->carroRepository->update($request->all(),$id);
    }

    public function delete($id){
        return $this->carroRepository->delete($id);
    }

    public function getRequest(Request $request){
        if(empty($request->get('marca'))){
            if(empty($request->all()[0]['marca'])){
                return ['marca' => 'required'];
            }
            return [
                '*.marca' => 'required',
                '*.modelo' => 'required',
                '*.ano' => 'required'
            ];
        }else{
            return [
                'marca' => 'required',
                'modelo' => 'required',
                'ano' => 'required',
            ];
        }
    }
}
