<?php

declare(strict_types=1);

namespace Cars\Tests;

use App\Response;

use \PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    private Response $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->response = new Response();
    }

    public function testJson(): void
    {
        $this->assertNull($this->response->json([]));
    }
}
