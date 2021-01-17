<?php

namespace App\Contracts;


interface RepositoryInterface

{
    public function all();

    public function find(int $id): ?object;

    public function findByColumn(string $column, $value): ?object;

    public function save(array $attributes): bool;

    public function update(int $id, array $attributes): bool;
}
