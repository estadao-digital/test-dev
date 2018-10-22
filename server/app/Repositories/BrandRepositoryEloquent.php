<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\BrandRepository;
use App\Brand;

/**
 * Class BrandRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class BrandRepositoryEloquent extends BaseRepository implements BrandRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Brand::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
