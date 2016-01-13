<?php

/**
 *
 */
class ViaNett_Send extends ViaNett_Client {

  private $sender;
  private $receiver;
  private $message;
  private $messageId;
  private $messageOptions;

  /**
   * @return bool
   * @throws \Exception
   */
  public function send() {
    $url = $this->prepareUrl();
    return $this->doRequest($url);
  }

  /**
   * @return string
   */
  public function debug() {
    return $this->prepareUrl();
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
   * @param $options
   */
  public function setMessageOptions($options) {
    $this->messageOptions = $options;
  }

  /**
   * @param $sender
   * @param $receiver
   * @param $message
   * @param $message_id
   * @param $options
   */
  public function prepareSMS($sender, $receiver, $message, $message_id, $options = array()) {
    $this->setSender($sender);
    $this->setReceiver($receiver);
    $this->setMessage($message);
    $this->setMessageId($message_id);
    $this->setMessageOptions($options);
  }

  /**
   * @throws \Exception
   */
  private function doValidation() {
    if (!$this->sender) {
      throw new Exception('Missing sender value.');
    }
    if (!$this->receiver) {
      throw new Exception('Missing receiver value.');
    }
    if (!$this->message) {
      throw new Exception('Missing message value.');
    }
    if (!$this->messageId) {
      throw new Exception('Missing message id value.');
    }
  }

  /**
   * @return string
   * @throws \Exception
   */
  protected function prepareUrl() {
    $this->doValidation();

    $fields = array(
      'username' => $this->getUsername(),
      'password' => $this->getPassword(),
      'SenderAddress' => $this->sender,
      'tel' => $this->receiver,
      'msg' => $this->message,
      'msgid' => $this->messageId,
    );

    // Append additional options.
    if ($this->messageOptions) {
      $fields += $this->messageOptions;
    }

    return http_build_query($fields);
  }
}
