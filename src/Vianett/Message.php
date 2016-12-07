<?php

namespace Vianett;

/**
 *
 */
class Message {

  protected $sender;
  protected $receiver;
  protected $message;
  protected $messageId;

  /**
   * @var \Vianett\Client
   */
  protected $client;

  /**
   * Send constructor.
   * @param \Vianett\Client $client
   */
  public function __construct(Client $client) {
    $this->client = $client;
  }

  /**
   * @return bool
   * @throws \Exception
   */
  public function send() {
    $this->doValidation();
    $values = $this->prepareValues();
    return $this->client->doRequest($values);
  }

  /**
   * @return string
   */
  public function debug() {
    $this->doValidation();
    return $this->prepareValues();
  }

  /**
   * @param $sender
   */
  public function setClient(Client $client) {
    $this->client = $client;
  }

  /**
   * @param $sender
   */
  public function setSender($sender) {
    $this->sender = $sender;
  }

  /**
   * @param $receiver
   */
  public function setReceiver($receiver) {
    $this->receiver = $receiver;
  }

  /**
   * @param $message
   */
  public function setMessage($message) {
    $this->message = $message;
  }

  /**
   * @param $messageId
   */
  public function setMessageId($messageId) {
    $this->messageId = $messageId;
  }

  /**
   * @param $sender
   * @param $receiver
   * @param $message
   * @param $message_id
   */
  public function prepare($sender, $receiver, $message, $message_id) {
    $this->setSender($sender);
    $this->setReceiver($receiver);
    $this->setMessage($message);
    $this->setMessageId($message_id);
  }

  /**
   * @throws \Exception
   */
  private function doValidation() {
    if (!$this->sender) {
      throw new \Exception('Missing sender value.');
    }
    if (!$this->receiver) {
      throw new \Exception('Missing receiver value.');
    }
    if (!$this->message) {
      throw new \Exception('Missing message value.');
    }
    if (!$this->messageId) {
      throw new \Exception('Missing message id value.');
    }
  }

  /**
   * @return string
   * @throws \Exception
   */
  protected function prepareValues() {
    return array(
      'SenderAddress' => $this->sender,
      'Tel' => $this->receiver,
      'msg' => $this->message,
      'msgid' => $this->messageId,
      //SenderAddressType
      //msgbinary
      //msgheader
      //ReplyPathValue
      //ReplypathID
      //ScheduledDate
      //ScheduledSMSCDate
      //ReferenceID
      //CheckForDuplicates
      //MMSdata
      //mmsurl
      //PriceGroup
      //CampaignID
      //TeleOp
      //Nrq
      //Priority
      //HLRMCC/HLRMNC/HLRDate
    );
  }
}
