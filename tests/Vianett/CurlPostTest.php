<?php

namespace Vianett;

class CurlPostTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \Vianett\Client
   */
  protected $client;

  /**
   * @var \Vianett\CurlGet
   */
  protected $httpRequest;

  public function setUp() {
    $this->client = new Client('username', 'password');
    $this->httpRequest = new CurlPost();
    $this->client->setHttpRequest($this->httpRequest);
  }

  public function testSetValues() {
    $values = [
      'testKey' => 'testValue'
    ];
    $this->httpRequest->setValues($values);
  }

  public function testGetCode() {
    $this->assertEquals(0, $this->httpRequest->getCode());
  }

  public function testClose() {
    $this->httpRequest->close();
  }

}
