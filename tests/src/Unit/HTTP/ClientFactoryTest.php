<?php

namespace zaporylie\Vianett\Test\Unit\HTTP;

use Http\Adapter\Guzzle6\Client;

class ClientFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Http\Client\HttpAsyncClient|\Http\Client\HttpClient;
     */
    protected $fakeClient;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->fakeClient = \Mockery::Mock('\Http\Client\HttpClient');
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Tests client autodiscovery.
     */
    public function testClientDiscovery()
    {
        $client = \zaporylie\Vianett\HTTP\ClientFactory::get();
        $this->assertEquals(Client::class, get_class($client));
    }

    /**
     * Tests explicit client set.
     */
    public function testClientExplicit()
    {
        $client = \zaporylie\Vianett\HTTP\ClientFactory::get($this->fakeClient);
        $this->assertEquals('Mockery_0_Http_Client_HttpClient', get_class($client));
    }

    /**
     * @expectedException \LogicException
     */
    public function testClientFailExplicit()
    {
        \zaporylie\Vianett\HTTP\ClientFactory::get(new \stdClass());
    }
}
