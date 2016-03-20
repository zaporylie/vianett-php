<?php

namespace Vianett;

/**
 * Class CurlGet
 * @package Vianett
 *
 * @codeCoverageIgnore
 */
class CurlGet extends VianettHttpRequest implements HttpRequestInterface, CurlInterface
{
  protected $request;
  protected $path;
  protected $values;

  public function __construct($values, $path = self::HOST) {
    $this->request = curl_init();
    $this->values = $values;
    $this->path = $path;
    $this->setOptions();
  }

  public function execute() {
    return curl_exec($this->request);
  }

  public function getCode() {
    return curl_getinfo($this->request, CURLINFO_HTTP_CODE);
  }

  public function close() {
    curl_close($this->request);
  }

  public function setOptions() {
    curl_setopt($this->request, CURLOPT_URL, $this->path . '?' . http_build_query($this->values));
    curl_setopt($this->request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($this->request, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($this->request, CURLOPT_SSL_VERIFYPEER, false);
  }
}
