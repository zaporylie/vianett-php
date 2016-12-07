<?php

namespace Vianett;

/**
 * Class CurlPost
 * @package Vianett
 */
class CurlPost extends VianettHttpRequest implements HttpRequestInterface, CurlInterface
{

  protected $request;

  public function init() {
    $this->request = curl_init();
  }

  /**
   * @codeCoverageIgnore
   */
  public function execute() {
    return curl_exec($this->request);
  }

  public function getCode() {
    return curl_getinfo($this->request, CURLINFO_HTTP_CODE);
  }

  public function close() {
    curl_close($this->request);
  }

  public function __construct($values = array()) {
    $this->init();
    $this->setValues($values);
    $this->setOptions();
  }

  public function setValues($values = array()) {
    parent::setValues($values);
    curl_setopt($this->request, CURLOPT_POSTFIELDS, $this->values);
  }

  public function setOptions() {
    curl_setopt($this->request, CURLOPT_URL, self::HOST);
    curl_setopt($this->request, CURLOPT_POST, 1);
    curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->request, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, false);
  }
}
