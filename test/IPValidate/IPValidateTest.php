<?php

namespace Pamo\IPValidate;

use PHPUnit\Framework\TestCase;

/**
 * test class.
 */
class IPValidateTest extends TestCase
{
    /**
     * Test isValid
     */
    public function testIsValid()
    {
        $this->ipvalidate = new IPValidate;
        $res = $this->ipvalidate->isValid("8.8.8.8");
        $this->assertIsBool($res);
    }

    /**
     * Test getType
     */
    public function testGetType()
    {
        $this->ipvalidate = new IPValidate;
        $exp = "IPv4";
        $res = $this->ipvalidate->getType("8.8.8.8");
        $this->assertEquals($res, $exp);

        $exp = "IPv6";
        $res = $this->ipvalidate->getType("2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $this->assertEquals($res, $exp);
    }

    /**
     * Test getDomain
     */
    public function testGetDomain()
    {
        $this->ipvalidate = new IPValidate;
        $res = $this->ipvalidate->getDomain("8.8.8.8");
        $this->assertIsString($res);
    }
}
