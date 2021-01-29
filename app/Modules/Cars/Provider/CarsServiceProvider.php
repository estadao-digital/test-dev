<?php
namespace App\Modules\Cars\Provider;

use App\Modules\Cars\Domain\CarsDomain;
use App\Modules\Cars\Repository\CarsRepository;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

class CarsServiceProvider
{
    private $carsRepository;
    
    function __construct(CarsRepository $carsRepository)
    {
        $this->carsRepository = $carsRepository;
    }

    public function index()
    {
        return view('cars.index');
    }


    public function create()
    {
        return view('cars.create');
    }

    
    public function store($request)
    {
        DB::beginTransaction();
        try {
            $new = CarsDomain::_new(
                Uuid::generate()->string,
                $request->brand,
                $request->model,
                $request->year
            );
            $this->carsRepository->_save($new);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Car saved successfully!', 'data' => json_encode($new)]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit($id)
    {
        $carsuser = CarsRepository::_getCarById($id);

        return view('cars.edit', compact('carsuser'));
    }


    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $edit = CarsDomain::_update(
                $id,
                $request->brand,
                $request->model,
                $request->year
            );
            $this->carsRepository->_save($edit);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Car edited successfully!', 'data' => json_encode($edit)]);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->carsRepository->_destroy($id);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Car deleted successfully!']);
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function getAllCars()
    {
        return CarsRepository::_getAllCars();
    }

    public function getCarById($id)
    {
        return CarsRepository::_getCarById($id);
    }
}