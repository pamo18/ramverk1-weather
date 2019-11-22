<?php

namespace Pamo\IPGeotag;

use PHPUnit\Framework\TestCase;

/**
 * test class.
 */
class IPGeotagTest extends TestCase
{
    /**
     * Test getAllData
     */
    public function testGetAllData()
    {
        $this->ipGeotager = new IPGeotag;
        $this->ipGeotager->init();
        $res = $this->ipGeotager->getAllData("8.8.8.8");
        $this->assertIsObject($res);
    }

    /**
     * Test getAllDataSorted
     */
    public function testGetAllDataSorted()
    {
        $this->ipGeotager = new IPGeotag;
        $this->ipGeotager->init();
        $res = $this->ipGeotager->getAllDataSorted("8.8.8.8");
        $this->assertIsArray($res);
    }

    /**
     * Test getClientIP
     */
    public function testGetClientIP()
    {
        $this->ipGeotager = new IPGeotag;
        $this->ipGeotager->init();

        $_SERVER["HTTP_CLIENT_IP"] = "0.0.0.0";
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
        unset($_SERVER["HTTP_CLIENT_IP"]);

        $_SERVER["HTTP_X_FORWARDED_FOR"] = "0.0.0.0";
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
        unset($_SERVER["HTTP_X_FORWARDED_FOR"]);

        $_SERVER["HTTP_X_FORWARDED"] = "0.0.0.0";
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
        unset($_SERVER["HTTP_X_FORWARDED"]);

        $_SERVER["HTTP_FORWARDED_FOR"] = "0.0.0.0";
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
        unset($_SERVER["HTTP_FORWARDED_FOR"]);

        $_SERVER["HTTP_FORWARDED"] = "0.0.0.0";
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
        unset($_SERVER["HTTP_FORWARDED"]);

        $_SERVER["REMOTE_ADDR"] = "0.0.0.0";
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
        unset($_SERVER["REMOTE_ADDR"]);
    }

    /**
     * Test getClientIP
     */
    public function testGetClientIPTest()
    {
        $this->ipGeotager = new IPGeotag;
        $this->ipGeotager->init();
        $res = $this->ipGeotager->getClientIP("unknown");
        $this->assertIsString($res);
    }

    /**
     * Test getClientIP
     */
    public function testGetClientIPUnknown()
    {
        unset($_SERVER["HTTP_CLIENT_IP"]);
        unset($_SERVER["HTTP_X_FORWARDED_FOR"]);
        unset($_SERVER["HTTP_X_FORWARDED"]);
        unset($_SERVER["HTTP_FORWARDED_FOR"]);
        unset($_SERVER["HTTP_FORWARDED"]);
        unset($_SERVER["REMOTE_ADDR"]);

        $this->ipGeotager = new IPGeotag;
        $this->ipGeotager->init();
        $res = $this->ipGeotager->getClientIP();
        $this->assertIsString($res);
    }
}
