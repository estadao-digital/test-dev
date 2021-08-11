<?php

require_once 'Dummy/DummyController.php';

class RouterControllerTest extends \PHPUnit\Framework\TestCase
{

    public function testGet()
    {
        // Match normal route on alias
        TestRouter::controller('/url', 'DummyController');

        $response = TestRouter::debugOutput('/url/test', 'get');

        $this->assertEquals('getTest', $response);

    }

    public function testPost()
    {
        // Match normal route on alias
        TestRouter::controller('/url', 'DummyController');

        $response = TestRouter::debugOutput('/url/test', 'post');

        $this->assertEquals('postTest', $response);

    }

    public function testPut()
    {
        // Match normal route on alias
        TestRouter::controller('/url', 'DummyController');

        $response = TestRouter::debugOutput('/url/test', 'put');

        $this->assertEquals('putTest', $response);

    }

}