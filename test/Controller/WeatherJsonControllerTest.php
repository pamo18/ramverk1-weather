<?php

namespace Pamo\WeatherJson;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class WeatherJsonControllerTest extends TestCase
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
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // Use a different cache dir for unit test
        $this->di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new WeatherJsonController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "test" => "8.8.8.8"
            ]
        ]);
        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Weather";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "test" => "unknown"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Weather";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $exp = "Post an ip address to the route /ip-geotag-json";
        $exp2 = "Geotag IP Address to JSON";
        $this->assertContains($exp || $exp2, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "search" => "37.419158935547,-122.07540893555",
                "do-weather-history-json" => true
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "USA";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "get" => [
                "search" => "källby"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Sweden";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "search" => "0.0.0.0"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Weather";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "search" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Weather";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "search" => "2001:0db8:85a3:0000:0000:8a2e:0370:7334"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Weather";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "search" => "italy"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Italy";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "get" => [
                "search" => "italy"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Italy";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "get" => [
                "test-search" => "italy"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Italy";
        $this->assertContains($exp, $json);
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
