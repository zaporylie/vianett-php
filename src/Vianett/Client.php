<?php

namespace Vianett;

/**
 *
 */
class Client {

  protected $username;
  protected $password;

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
  public function getUsername() {
    return $this->username;
  }

  /**
   * @return mixed
   */
  public function getPassword() {
    return $this->password;
  }

  /**
   * @param $username
   */
  public function setUsername($username) {
    $this->username = $username;
  }

  /**
   * @param $password
   */
  public function setPassword($password) {
    $this->password = $password;
  }

  /**
   * @param $url
   * @return bool
   * @throws \Exception
   * @codeCoverageIgnore
   */
  public function doRequest($values) {
    $values += [
      'username' => $this->getUsername(),
      'password' => $this->getPassword(),
    ];
    $request = new CurlGet($values);
    $response = $request->execute();
    $code = $request->getCode();
    $request->close();
    $this->parseResponse($request, $code);
  }

  /**
   * @param $response
   * @return bool
   * @throws \Exception
   */
  public function parseResponse($response, $code) {

    if (empty($response)) {
      throw new \Exception('No response.', $code);
    }
    if ($code >= 400) {
      throw new \Exception('Incorrect response code.', $code);
    }

    $response = simplexml_load_string($response);
    if (!isset($response->attributes()->errorcode)) {
      throw new \Exception('Something went wrong. Unable to get valid response.');
    }
    $code = (string) $response->attributes()->errorcode;
    if ($code == 200) {
      return TRUE;
    }
    else {
      throw new \Exception((string) $response, $code);
    }
  }

}
