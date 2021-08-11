<?php

require_once 'Dummy/DummyMiddleware.php';
require_once 'Dummy/DummyController.php';

class RouterGroupTest extends \PHPUnit\Framework\TestCase
{

    public function testGroupLoad()
    {
        $result = false;

        TestRouter::group(['prefix' => '/group'], function () use (&$result) {
            $result = true;
        });

        try {
            TestRouter::debug('/', 'get');
        } catch (\Exception $e) {

        }
        $this->assertTrue($result);
    }

    public function testNestedGroup()
    {

        TestRouter::group(['prefix' => '/api'], function () {

            TestRouter::group(['prefix' => '/v1'], function () {
                TestRouter::get('/test', 'DummyController@method1');
            });

        });

        TestRouter::debug('/api/v1/test', 'get');

        $this->assertTrue(true);
    }

    public function testMultipleRoutes()
    {

        TestRouter::group(['prefix' => '/api'], function () {

            TestRouter::group(['prefix' => '/v1'], function () {
                TestRouter::get('/test', 'DummyController@method1');
            });

        });

        TestRouter::get('/my/match', 'DummyController@method1');

        TestRouter::group(['prefix' => '/service'], function () {

            TestRouter::group(['prefix' => '/v1'], function () {
                TestRouter::get('/no-match', 'DummyController@method1');
            });

        });

        TestRouter::debug('/my/match', 'get');

        $this->assertTrue(true);
    }

    public function testUrls()
    {
        // Test array name
        TestRouter::get('/my/fancy/url/1', 'DummyController@method1', ['as' => 'fancy1']);

        // Test method name
        TestRouter::get('/my/fancy/url/2', 'DummyController@method1')->setName('fancy2');

        TestRouter::debugNoReset('/my/fancy/url/1');

        $this->assertEquals('/my/fancy/url/1/', TestRouter::getUrl('fancy1'));
        $this->assertEquals('/my/fancy/url/2/', TestRouter::getUrl('fancy2'));

        TestRouter::router()->reset();

    }

    public function testNamespaceExtend()
    {
        TestRouter::group(['namespace' => '\My\Namespace'], function () use (&$result) {

            TestRouter::group(['namespace' => 'Service'], function () use (&$result) {

                TestRouter::get('/test', function () use (&$result) {
                    return \Pecee\SimpleRouter\SimpleRouter::router()->getRequest()->getLoadedRoute()->getNamespace();
                });

            });

        });

        $namespace = TestRouter::debugOutput('/test');
        $this->assertEquals('\My\Namespace\Service', $namespace);
    }

    public function testNamespaceOverwrite()
    {
        TestRouter::group(['namespace' => '\My\Namespace'], function () use (&$result) {

            TestRouter::group(['namespace' => '\Service'], function () use (&$result) {

                TestRouter::get('/test', function () use (&$result) {
                    return \Pecee\SimpleRouter\SimpleRouter::router()->getRequest()->getLoadedRoute()->getNamespace();
                });

            });

        });

        $namespace = TestRouter::debugOutput('/test');
        $this->assertEquals('\Service', $namespace);
    }

}