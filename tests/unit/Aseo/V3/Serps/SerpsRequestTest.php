<?php
namespace Aseo\Api\Tests;

use Aseo\Api\V3\Serps\SerpsRequest;

class SerpsRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Search Engine is not supported
     */
    public function testSetInvalidSearchEngine()
    {
        $sr = new SerpsRequest(array(
            'search_engine' => 'foo'
        ));

    }

    public function testSetSearchEngine()
    {
        $sr = new SerpsRequest(array(
            'search_engine' => 'google'
        ));

        $this->assertEquals('google', $sr->getSearchEngine());

    }

    public function testSetRegion()
    {
        $sr = new SerpsRequest(array(
            'region' => 'value'
        ));

        $this->assertEquals('value', $sr->getRegion());

    }

    public function testSetTown()
    {
        $sr = new SerpsRequest(array(
            'town' => 'value'
        ));

        $this->assertEquals('value', $sr->getTown());

    }

    public function testSetSearchType()
    {
        $sr = new SerpsRequest(array(
            'search_type' => 'value'
        ));

        $this->assertEquals('value', $sr->getSearchType());

    }

    public function testSetLanguage()
    {
        $sr = new SerpsRequest(array(
            'language' => 'value'
        ));

        $this->assertEquals('value', $sr->getLanguage());

    }

    public function testSetMaxResults()
    {
        $sr = new SerpsRequest(array(
            'max_results' => 10
        ));

        $this->assertEquals(10, $sr->getMaxResults());

    }

    public function testSetPhrase()
    {
        $sr = new SerpsRequest(array(
            'phrase' => 'value'
        ));

        $this->assertEquals('value', $sr->getPhrase());

    }

    public function testSetUniversal()
    {
        $sr = new SerpsRequest(array(
            'universal' => 1
        ));

        $this->assertEquals(1, $sr->getUniversal());

    }

    public function testSetStrategy()
    {
        $sr = new SerpsRequest(array(
            'strategy' => 'value'
        ));

        $this->assertEquals('value', $sr->getStrategy());

    }

    public function testSetParameters()
    {
        $sr = new SerpsRequest(array(
            'parameters' => array()
        ));

        $this->assertEquals(array(), $sr->getParameters());

    }

    /**
     * @expectedExceptionMessage SERPS call does not support the parameter FOO
     * @expectedException OutOfBoundsException
     */
    public function testSetInvalidSerpsParameter()
    {
        $sr = new SerpsRequest(array(
            'FOO' => array()
        ));
    }

    public function testToString()
    {
        $data = array(
            'search_engine' => 'google',
            'language' => null, //null values are not included
        );

        $sr = new SerpsRequest($data);

        $expected = json_encode(array('search_engine' => 'google'));

        $this->assertEquals($expected, $sr);
    }
}
