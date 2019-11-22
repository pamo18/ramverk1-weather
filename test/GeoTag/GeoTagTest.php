<?php

namespace Pamo\GeoTag;

use PHPUnit\Framework\TestCase;

/**
 * test class.
 */
class GeoTagTest extends TestCase
{
    /**
     * Test getAllData
     */
    public function testGetAllData()
    {
        $this->GeoTager = new GeoTag;
        $this->GeoTager->init();
        $res = $this->GeoTager->getAllData("8.8.8.8");
        $this->assertInternalType("array", $res);
    }
}
