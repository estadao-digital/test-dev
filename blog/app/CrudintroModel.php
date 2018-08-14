<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class CrudintroModel extends Model
{

//    protected $fillable = ['name','description','quantity','price'];
//    protected $guarded = ['id', 'created_at', 'update_at'];
    protected $table = 'crudintro';

    public $timestamps = false;

    public function index(){
        return array("aa"=>"bb");

    }

    public function someText(){
        return DB::SELECT('select * from estoque_itens2;');
    }

    public function insert_raw(){

        return DB::SELECT('insert into estoque_itens2 (name) VALUES ("ddssE")');
    }
}
