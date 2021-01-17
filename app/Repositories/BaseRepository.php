<?php


namespace App\Repositories;


use App\Contracts\RepositoryInterface;

class BaseRepository implements RepositoryInterface
{
    protected $model;

    protected function __construct(object $model)
    {
        $this->model = $model;
    }

    public function all(): object
    {
        return $this->model->all();
    }

    public function find(int $id): ?object
    {
        return $this->model->find($id);
    }

    public function findByColumn(string $column, $value): ?object
    {
        return $this->model->where($column, $value)->get();
    }

    public function save(array $attributes): bool
    {
        return $this->model->insert($attributes);
    }

    public function create(array $attributes): object
    {
        return $this->model->create($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->model->find($id)->update($attributes);
    }

    public function destroy(int $id)
    {
        return $this->model->destroy($id);
    }
}
