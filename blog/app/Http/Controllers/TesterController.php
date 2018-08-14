<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tester;

use App\Product;

use App\Http\Requests\TesterRequest;

use Illuminate\Support\Facades\DB;

class TesterController extends Controller
{
    public function index()
    {

        return view('tester.index',['' => '']);

    }

    public function update_tester(Request $request, tester $tester){

//          $test = new Tester();

          //DB::table('product')->insert($request->all());

          return view('tester.index',['product' => '']);

//        $tester->setRawAttributes($request->all());
//
//        $tester->save();
//
//        dd(Tester::all()->toArray());
//
//        $tester->name = $request->name;
//        $tester->save();
//        dd($tester->attributesToArray());
//
//
//        dd(product::all()->toArray());
//
//        $result = DB::table('product')->where('name', 'asdf')->get();
//
//
//
////        $tester->alterar_registro();
//
////        $tester = new Tester();
//
////        dd($tester);
//
//        die('end');

    }

    public function store(TesterRequest $request){

        return view('tester.index',['product' => '']);


        $this->validate($request, ['name' => 'required']);

    }




}
