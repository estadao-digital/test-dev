<?php

declare(strict_types=1);

namespace Cars\Tests;

use App\CarFile;

use \PHPUnit\Framework\TestCase;

class CarFileTest extends TestCase
{
    private CarFile $file;

    protected function setUp(): void
    {
        parent::setUp();

        $this->file = new CarFile();
    }

    public function testUpdate(): void
    {
        $this->assertNull($this->file->update([]));
    }

    public function testGetData(): void
    {
        $this->assertIsArray($this->file->getData());
    }
}
