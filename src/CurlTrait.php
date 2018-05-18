<?php

namespace Vianett;

trait CurlTrait {

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
}
