<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\App;

use App\Product;
use App\estoque_itens2;

use Illuminate\Support\Facades\Redirect;
use function Psy\debug;


class ProductController extends Controller
{
    public function index()
    {

        $product_model = new Product();

//        dd($product_model->someText());

        return view('product.index',['product' => $product_model->index()]);

//        return view('product.index');
//        return redirect()->route('product.index')->with('message', 'Product updated successfully!');
//        return view('product.index',['product' => ""]);
    }

    public function layboot(){

        return view('product.layboot');

    }

    public function create(Request $request)
    {
        $product_model = new Product();

        $product_model->name = $request->codigoAnterior;

        $product_model->save();

        echo "<pre>";
        print_r($request->all());

        echo "<br><br><br>";

        die('dde');
        return view('products.create');
    }

    public function store(Request $request, product $product)
    {


        echo "<pre>";
        print_r($product->attributesToArray());


        echo "<br><br><br>";

//      $product->update($request->all());
        die('storeeee');

        print_r($request->all());
        echo "</pre>";


        die(var_dump($request));

//        die('dd' . $request);

        $product = new Product;
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->save();
        return redirect()->route('products.index')->with('message', 'Product created successfully!');
    }

    public function show($id)
    {
        //
    }

    public function salva_produto(Request $request)
    {
        $di = new IntegracaoCeleraProdutos();
//        $aodfij = \modulo

        dd($request->all());

    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.edit',compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->name        = $request->name;
        $product->description = $request->description;
        $product->quantity    = $request->quantity;
        $product->price       = $request->price;
        $product->save();
        return redirect()->route('products.index')->with('message', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('alert-success','Product hasbeen deleted!');
    }
}
