<?php

define('VIANETT_CLIENT_HOST', 'http://smsc.vianett.no/V3/CPA/MT/MT.ashx');

/**
 *
 */
class ViaNett_Client {

  private $username;
  private $password;

  /**
   * Class constructor.
   *
   * @param $username
   *   ViaNett account username.
   * @param $password
   *   ViaNett account password.
   */
  public function __construct($username, $password) {
    $this->setUsername($username);
    $this->setPassword($password);
  }

  /**
   * @return mixed
   */
  protected function getUsername() {
    return $this->username;
  }

  /**
   * @return mixed
   */
  protected function getPassword() {
    return $this->password;
  }

  /**
   * @param $url
   * @return bool
   * @throws \Exception
   */
  protected function doRequest($url) {
    $request = curl_init();
    curl_setopt($request, CURLOPT_URL, VIANETT_CLIENT_HOST . '?' . $url);
    curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($request, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($request, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($request);
    $code = curl_getinfo($request, CURLINFO_HTTP_CODE);
    curl_close($request);
    if (!$response) {
      throw new Exception('No response', $code);
    }
    if ($code <> 200) {
      throw new Exception('Wrong response code', $code);
    }
    return $this->parseResponse($response);
  }

  /**
   * @param $username
   */
  private function setUsername($username) {
    $this->username = $username;
  }

  /**
   * @param $password
   */
  private function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @param $response
   * @return bool
   * @throws \Exception
   */
  private function parseResponse($response) {
    $response = simplexml_load_string($response);
    if (!isset($response->attributes()->errorcode)) {
      throw new Exception('Something went wrong. Unable to get valid response.');
    }
    $code = (string) $response->attributes()->errorcode;
    if ($code == 200) {
      return TRUE;
    }
    else {
      throw new Exception((string) $response, $code);
    }
  }

}
