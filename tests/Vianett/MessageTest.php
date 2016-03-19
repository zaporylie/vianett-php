<?php

namespace Vianett;

class MessageTest extends \PHPUnit_Framework_TestCase
{

  /**
   * @var \Vianett\Client
   */
  protected $client;

  /**
   * @var \Vianett\Message
   */
  protected $message;

  public function setUp() {
    $this->client = new Client('username', 'password');
    $this->message = new Message($this->client);
  }

  public function testSend()
  {

  }

  public function testClient()
  {
    $client = new Client('username2', 'password2');
    $this->message->setClient($client);
  }

  public function testPrepare()
  {
    $username = $this->client->getUsername();
    $password = $this->client->getPassword();
    $sender = 'sender';
    $receiver = 'receiver';
    $message = 'message';
    $message_id = 'message_id';
    $this->message->prepare($sender, $receiver, $message, $message_id);
    $url = $this->message->debug();
    $this->assertContains("username=$username", $url);
    $this->assertContains("password=$password", $url);
    $this->assertContains("SenderAddress=$sender", $url);
    $this->assertContains("tel=$receiver", $url);
    $this->assertContains("msg=$message", $url);
    $this->assertContains("msgid=$message_id", $url);
  }

  public function testSearch() {
    $client = $this->getMockBuilder('\Vianett\Client')
      ->disableOriginalConstructor()
      ->getMock();
    $client->expects($this->any())
      ->method('doRequest')
      ->will($this->returnValue('test'));

    $this->message->setClient($client);
    $this->message->prepare('t', 'e', 's', 't');
    $response = $this->message->send();
    $this->assertEquals('test', $response);
  }

  /**
   * @expectedException        \Exception
   * @expectedExceptionMessage Missing sender value.
   */
  public function testSenderValidation()
  {
    $this->message->debug();
  }

  /**
   * @expectedException        \Exception
   * @expectedExceptionMessage Missing receiver value.
   */
  public function testReceiverValidation()
  {
    $this->message->setSender('test');
    $this->message->debug();
  }

  /**
   * @expectedException        \Exception
   * @expectedExceptionMessage Missing message value.
   */
  public function testMessageValidation()
  {
    $this->message->setSender('test');
    $this->message->setReceiver('test');
    $this->message->debug();
  }

  /**
   * @expectedException        \Exception
   * @expectedExceptionMessage Missing message id value.
   */
  public function testMessageIdValidation()
  {
    $this->message->setSender('test');
    $this->message->setReceiver('test');
    $this->message->setMessage('test');
    $this->message->debug();
  }

}
