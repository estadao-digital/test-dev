<?php
/**
 * Created by PhpStorm.
 * User: mcnei
 * Date: 08/08/2020
 * Time: 15:44
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DatabaseRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CarController extends Controller
{
    /**
     * @var DatabaseRepository
     */
    private $repository;

    public function __construct(DatabaseRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = $this->repository->getAll();
        return response()->json($vehicles);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = $this->repository->find('id', $id);
        $code = ($vehicle) ? Response::HTTP_OK : Response::HTTP_NOT_FOUND;
        return response()->json($vehicle, $code);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'model' => 'required|min:2|max:255',
            'year' => 'required|numeric|min:1900',
        ];
        $validator = Validator::make($request->json()->all(), $rules);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
        }
        $vehicle = $this->repository->store($request->json()->all());
        return response()->json($vehicle, Response::HTTP_CREATED);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $rules = [
            'model' => 'required|min:2|max:255',
            'year' => 'required|numeric|min:1900',
        ];
        $validator = Validator::make($request->json()->all(), $rules);

        if ($validator->fails()) {
            return response()
                ->json([
                    'errors' => $validator->errors()
                ], Response::HTTP_BAD_REQUEST);
        }
        $vehicle = $this->repository->setVehicle($id, $request->json()->all());
        return response()->json($vehicle, Response::HTTP_ACCEPTED);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $success = $this->repository->removeVehicle($id);
        $status = ['success' => $success];
        return response()->json($status , Response::HTTP_OK);
    }
}
