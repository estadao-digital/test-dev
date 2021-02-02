<?php

declare(strict_types=1);

namespace Cars\Tests;

use App\Cars;

use \PHPUnit\Framework\TestCase;

class CarsTest extends TestCase
{
    private Cars $cars;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cars = new Cars();

        ob_start();
    }

    public function testAll(): void
    {
        $this->assertNull($this->cars->all());
    }

    public function testGet(): void
    {
        $this->assertNull($this->cars->get(1));
    }

    public function testAdd(): void
    {
        $this->assertNull($this->cars->add());
    }

    public function testUpdate(): void
    {
        $this->assertNull($this->cars->update(50));
    }

    public function testDelete(): void
    {
        $this->assertNull($this->cars->delete(50));
    }

    public function tearDown(): void
    {
        ob_end_clean();
    }
}
