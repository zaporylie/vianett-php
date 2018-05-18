<?php

namespace Vianett;

/**
 * Class CurlGet
 * @package Vianett
 */
class CurlGet extends VianettHttpRequest implements HttpRequestInterface, CurlInterface
{
  use CurlTrait;

  public function __construct($values = []) {
    $this->init();
    $this->setValues($values);
    $this->setOptions();
  }

  public function setValues($values = []) {
    parent::setValues($values);
    curl_setopt($this->request, CURLOPT_URL, self::HOST . '?' . http_build_query($this->values));
  }

  public function setOptions() {
    curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->request, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, false);
  }
}
