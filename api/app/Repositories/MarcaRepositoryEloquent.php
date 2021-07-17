<?php

namespace App\Repositories;

use App\Models\Marca;
use Illuminate\Support\Facades\File;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;


/**
 * Class CarroRepositoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MarcaRepositoryEloquent extends BaseRepository implements MarcaRepository
{
    private $dir;
    private $path;
    private $marcas;
    /**
     * CarroRepositoryEloquent constructor.
     */
    public function __construct()
    {
        $this->dir = base_path(env('PATH_JSON'));
        $this->path = $this->dir. env('BASE_MARCA');

        if(!File::exists($this->path)){
            File::makeDirectory($this->dir,0755, true, true);
            File::put($this->path,json_encode([]));
        }

        $base = File::get($this->path);
        $this->marcas = json_decode($base);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Marca::class;
    }

    public function all($columns = ['*'])
    {
        $marcas = collect($this->marcas);
        if($marcas->count()>0){
            return $marcas;
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



}
