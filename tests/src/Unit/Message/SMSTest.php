<?php

namespace zaporylie\Vianett\Test\Unit\Message;

use zaporylie\Vianett\Message\SMS;

class SMSTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \zaporylie\Vianett\VianettInterface;
     */
    protected $vianett;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->vianett = \Mockery::mock('\zaporylie\Vianett\VianettInterface[request]');
        $this->vianett->shouldReceive('request')->withAnyArgs()->andReturn(true);
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        \Mockery::close();
    }

    /**
     * Tests getters.
     */
    public function testGetters()
    {
        $sms = new SMS($this->vianett);
        $this->assertEquals(SMS::HOST, $sms->getBaseUrl());
        $this->assertEquals(SMS::METHOD, $sms->getMethod());
        $this->assertEquals(SMS::URI, $sms->getUri());
    }

    /**
     * Tests sending message.
     */
    public function testSend()
    {
        $sms = new SMS($this->vianett);
        $response = $sms->send('sender', 'recipient', 'message', []);
        $this->assertEquals(true, $response);
    }
}
