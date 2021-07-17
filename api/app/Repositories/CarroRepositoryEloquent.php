<?php

namespace App\Repositories;

use App\Models\Carro;

use Illuminate\Support\Facades\File;
use phpDocumentor\Reflection\Types\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class CarroRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CarroRepositoryEloquent extends BaseRepository implements CarroRepository
{
    private $dir;
    private $path;
    private $path_marcas;
    private $carros;
    /**
     * CarroRepositoryEloquent constructor.
     */
    public function __construct()
    {
        $this->dir = base_path(env('PATH_JSON'));
        $this->path = $this->dir. env('BASE_CARRO');
        $this->path_marcas = $this->dir. env('BASE_MARCA');

        if(!File::exists($this->path)){
            File::makeDirectory($this->dir,0755, true, true);
            File::put($this->path,json_encode([]));
        }

        $base = File::get($this->path);
        $this->carros = json_decode($base);


    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Carro::class;
    }

    public function all($columns = ['*'])
    {
        $marcas = File::get($this->path_marcas);
        $marcas = collect(json_decode($marcas));

        $carros = collect($this->carros);
        if($carros->count()>0){
            return $carros->transform(function($res, $key) use ($marcas) {
                $marca = $marcas->where('id','=',$res->marca)->first();
                $response = collect($res);
                $response->put('nome_marca', $marca->title);
                return $response;
            })->all();
        }
        return collect();
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function create(array $attributes)
    {
        $carros = collect($this->carros);
        $max_id = $carros->max('id')+1;

        if (isset($attributes['marca'])) {
            $attributes['id'] = $max_id;
           $carros->push($attributes);
        }else{

            foreach ($attributes as $attribute) {
                $attribute['id'] = $max_id;
                $carros->push($attribute);
                $max_id++;
            }
        }

         File::put($this->path,json_encode($carros->toArray()));
         return collect($attributes);
    }


    public function update(array $attributes, $id)
    {
       $carros = collect($this->carros);
        $carros = $carros->map(function ($item, $key) use($id,$attributes) {
            if($item->id===(int)$id){
                $item->marca =$attributes['marca'];
                $item->modelo =$attributes['modelo'];
                $item->ano =$attributes['ano'];
              return $item;
            }
            return $item ;
        });

        File::put($this->path,json_encode($carros->toArray()));

        $attributes['id'] = $id;
        return $attributes;
    }


    public function delete($id)
    {
        $result =[];
        foreach ($this->carros as $c){
            if($c->id===(int)$id){
                unset($c);
                continue;
            }
            $result[] = $c;
        }

        File::put($this->path,json_encode($result));
        return;
    }
}
