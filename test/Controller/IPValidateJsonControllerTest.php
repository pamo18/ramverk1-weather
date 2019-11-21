<?php

namespace Pamo\IPValidateJson;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleJsonController.
 */
class IPValidateJsonControllerTest extends TestCase
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
        $this->controller = new IPValidateJsonController();
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
        $json = $res[0];

        $exp = "Post an ip address to the route /ip-address-json";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New post test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "8.8.8.8"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "8.8.8.8";
        $this->assertContains($exp, $json);

        $exp = "IPv4";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New post test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "2001:0db8:85a3:0000:0000:8a2e:0370:7334"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "2001:0db8:85a3:0000:0000:8a2e:0370:7334";
        $this->assertContains($exp, $json);

        $exp = "IPv6";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New post test-----------------------*/
        /*-------------------------------------*/
        $this->di->request->setGlobals([
            "post" => [
                "ip-address" => "10.258.0.0"
            ]
        ]);

        $res = $this->controller->indexAction();
        $this->assertInternalType("array", $res);
        $json = $res[0];

        $exp = "10.258.0.0";
        $this->assertContains($exp, $json);

        $exp = "invalid";
        $this->assertContains($exp, $json);

        /*-------------------------------------*/
        /*-New post test-----------------------*/
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

        /*-------------------------------------*/
        /*-New post test-----------------------*/
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
