<?php
/**
 * Created by PhpStorm.
 * User: ubuntu
 * Date: 25/10/19
 * Time: 14:31
 */
namespace App\Http\Services;

use App\Repositories\CarrosRepository;

class CarrosService
{
    private $repository;
    public function __construct(CarrosRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    public function update(array $data, $id)
    {
        return $this->repository->update($data,$id);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}