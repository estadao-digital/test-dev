<?php

require_once 'Dummy/ResourceController.php';

class RouterResourceTest extends \PHPUnit\Framework\TestCase
{

    public function testResourceStore()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource', 'post');

        $this->assertEquals('store', $response);
    }

    public function testResourceCreate()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource/create', 'get');

        $this->assertEquals('create', $response);

    }

    public function testResourceIndex()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource', 'get');

        $this->assertEquals('index', $response);
    }

    public function testResourceDestroy()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource/38', 'delete');

        $this->assertEquals('destroy 38', $response);
    }


    public function testResourceEdit()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource/38/edit', 'get');

        $this->assertEquals('edit 38', $response);

    }

    public function testResourceUpdate()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource/38', 'put');

        $this->assertEquals('update 38', $response);

    }

    public function testResourceGet()
    {
        TestRouter::resource('/resource', 'ResourceController');
        $response = TestRouter::debugOutput('/resource/38', 'get');

        $this->assertEquals('show 38', $response);

    }

}