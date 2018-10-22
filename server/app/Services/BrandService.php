<?php

namespace App\Services;

use App\Repositories\BrandRepository;

class BrandService
{
    /**
     * @var BrandRepository
     */
    private $repository;

    public function __construct(BrandRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * List All brands to database.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->all();
    }
}