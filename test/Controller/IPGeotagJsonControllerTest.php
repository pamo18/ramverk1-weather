<?php

namespace Pamo\IPGeotagJson;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
class IPGeotagJsonControllerTest extends TestCase
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
        $this->controller = new IPGeotagJsonController();
        $this->controller->setDI($this->di);
        $this->controller->initialize();
    }



    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);

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

        $exp = "Post an ip address to the route /ip-geotag-json";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "test" => "known"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "Geotag IP Address to JSON";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "0.0.0.0"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "valid";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "valid";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "2001:0db8:85a3:0000:0000:8a2e:0370:7334"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "valid";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "10.258.0.0"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "invalid";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "get" => [
                "test-ip" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "valid";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "get" => [
                "ip-address" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "valid";
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
