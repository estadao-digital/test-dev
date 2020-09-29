<?php

namespace App\Modules\Brands\Infra\Pixie\Entities;

final class Brand
{
  public $id;

  public $name;

  public function __construct(int $id, string $name)
  {
    $this->id = $id;
    $this->name = $name;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }
}
