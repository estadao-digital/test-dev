<?php
namespace App\Http\Controllers;

use App\Modules\Cars\Provider\CarsServiceProvider;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    private $carsServiceProvider;

    function __construct(CarsServiceProvider $carsServiceProvider)
    {
        $this->carsServiceProvider = $carsServiceProvider;
    }
    
    public function index()
    {
        return $this->carsServiceProvider->index();
    }
    
    public function create()
    {
        return $this->carsServiceProvider->create();
    }
    
    public function store(Request $request)
    {
        return $this->carsServiceProvider->store($request);
    }
    
    public function edit($id)
    {
        return $this->carsServiceProvider->edit($id);
    }
    
    public function update(Request $request, $id)
    {
        return $this->carsServiceProvider->update($request, $id);
    }
    
    public function destroy($id)
    {
        return $this->carsServiceProvider->destroy($id);
    }
}