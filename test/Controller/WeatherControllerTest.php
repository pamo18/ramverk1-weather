<?php

namespace Pamo\Weather;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class WeatherControllerTest extends TestCase
{

    // Create the di container.
    protected $di;
    protected $controller;



    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $body = $res->getBody();
        $this->assertContains("Weather", $body);

        $this->di->request->setGlobals([
            "post" => [
                "search" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $this->di->request->setGlobals([
            "get" => [
                "search" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $body = $res->getBody();
        $this->assertContains("Weather", $body);

        $this->di->request->setGlobals([
            "get" => [
                "search" => "källby"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $this->di->request->setGlobals([
            "get" => [
                "search" => "37.419158935547,-122.07540893555"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $this->di->request->setGlobals([
            "post" => [
                "search" => "2001:0db8:85a3:0000:0000:8a2e:0370:7334"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $this->di->request->setGlobals([
            "post" => [
                "search" => "10.258.0.0"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $this->di->request->setGlobals([
            "get" => [
                "search" => "0.0.0.0"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertIsObject($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }



    /**
     * Test the route "dump-di".
     */
    public function testDumpDiActionGet()
    {
        $res = $this->controller->dumpDiActionGet();
        $this->assertContains("di contains", $res);
        $this->assertContains("configuration", $res);
        $this->assertContains("request", $res);
        $this->assertContains("response", $res);
    }



    /**
     * Call the controller catchAll ANY.
     */
    public function testCatchAllGet()
    {
        $res = $this->controller->catchAll();
        $this->assertNull($res);
    }
}
