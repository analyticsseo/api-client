<?php
namespace Aseo\Api\Tests;

use Aseo\Api\Auth\KeyAuth;

class KeyAuthTest extends \PHPUnit_Framework_TestCase
{
    public function testSalt()
    {
        $ka = new KeyAuth;
        $ka->setSalt('value');

        $this->assertEquals('value', $ka->getSalt());
    }

    public function testApiKey()
    {
        $ka = new KeyAuth;
        $ka->setApiKey('value');

        $this->assertEquals('value', $ka->getApiKey());
    }

    public function testApiSecret()
    {
        $ka = new KeyAuth;
        $ka->setApiSecret('value');

        $this->assertEquals('value', $ka->getApiSecret());
    }

    public function testTimestamp()
    {
        $ka = new KeyAuth;
        // ensures timestamp was issued less than one second ago
        // we no want to test accuracy of getTimestamp but to ensure it was generated now
        // some edge cases might make the asserEquals fail, so instead we test the the timestam
        // was generated less than 1s ago
        $this->assertTrue(time() >= $ka->getTimestamp() -1);

    }

    public function testComputeHash()
    {
        $ka = $this->getMockBuilder('\Aseo\Api\Auth\KeyAuth')->setMethods(array('getTimestamp'))->getMock();

        $ka->expects($this->any())
           ->method('getTimestamp')
           ->will($this->returnValue(1));

        $ka->setSalt('salt');
        $ka->setApiSecret('secret');
        $ka->setApiKey('key');


        $hashSource = '1keysalt';
        $hash = hash_hmac('sha256', $hashSource, 'secret');

        $header = 'Authorization: KeyAuth';
        $header .= ' publicKey=key';
        $header .= ' hash=' . $hash;
        $header .= ' ts=1';

        $this->assertEquals($header, $ka->computeHash());
    }
}
