<?php

namespace Vianett;

/**
 *
 */
class Client {

  /**
   * @var
   */
  protected $username;

  /**
   * @var
   */
  protected $password;

  /**
   * @var HttpRequestInterface
   */
  protected $httpRequest;

  /**
   *
   */
  const DEFAULT_HTTP_REQUEST_CLASS = '\Vianett\CurlGet';

  /**
   * Class constructor.
   *
   * @param $username
   *   ViaNett account username.
   * @param $password
   *   ViaNett account password.
   */
  public function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
    $http_request = self::DEFAULT_HTTP_REQUEST_CLASS;
    $this->setHttpRequest(new $http_request());
  }

  /**
   * @return mixed
   */
  public function getUsername()
  {
    return $this->username;
  }

  /**
   * @return mixed
   */
  public function getPassword()
  {
    return $this->password;
  }

  /**
   * @param $username
   */
  public function setUsername($username)
  {
    $this->username = $username;
  }

  /**
   * @param $password
   */
  public function setPassword($password)
  {
    $this->password = $password;
  }

  /**
   * @param \Vianett\HttpRequestInterface $httpRequest
   */
  public function setHttpRequest(HttpRequestInterface $httpRequest)
  {
    $this->httpRequest = $httpRequest;
  }

  /**
   * @param $url
   * @return bool
   * @throws \Exception
   */
  public function doRequest($values)
  {
    $values += array(
      'username' => $this->username,
      'password' => $this->password
    );
    $this->httpRequest->setValues($values);
    $response = $this->httpRequest->execute();
    $code = $this->httpRequest->getCode();
    $this->httpRequest->close();
    $this->parseResponse($response, $code);
  }

  /**
   * @param $response
   * @return bool
   * @throws \Exception
   */
  public function parseResponse($response, $code)
  {

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
