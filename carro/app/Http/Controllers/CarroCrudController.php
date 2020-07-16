<?php

namespace App\Http\Controllers;

use App\Carro;
use App\Http\Requests\StoreUpdateCarroRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarroCrudController extends Controller
{
    protected $request;
    private $repository;

    public function __construct(Request $request, Carro $carro)
    {
        $this->request = $request;
        $this->repository = $carro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carros = $this->repository->latest()->paginate(10);
        
        return view('listar', [
            'carros' => $carros
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $carros = $this->repository->paginate(10);
        
        return view('create', [
            'carros' => $carros,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\StoreUpdateCarroRequest;  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUpdateCarroRequest $request)
    {
        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('carros.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(!$carros = $this->repository->find($id))
            return redirect()->back();

        return view('show', [
            'carro' => $carros
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $carros = $this->repository->All();

        if(!$carro = $this->repository->find($id))
            return redirect()->back();

        return view('edit', [
            'carro' => $carro,
            'carros' => $carros
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!$carro = $this->repository->find($id))
        return redirect()->back();

        $carro->update($request->all());

        return redirect()->route('carros.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carro = $this->repository->where('id', $id)->first();

        if(!$carro)
            return redirect()->back();

        $carro->delete();

        return redirect()->route('carros.index');
    }
}
