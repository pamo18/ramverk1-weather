<?php

namespace Pamo\Weather;

use PHPUnit\Framework\TestCase;

/**
 * test class.
 */
class WeatherTest extends TestCase
{
    /**
     * Test getAllData
     */
    public function testGetAllData()
    {
        $this->weather = new Weather;
        $this->weather->init();
        $res = $this->weather->getAllData("37.419158935547", "-122.07540893555", "history");
        $this->assertInternalType("array", $res);

        $res = $this->weather->getAllData("37.419158935547", "-122.07540893555", "forecast");
        $this->assertInternalType("array", $res);
    }
}
