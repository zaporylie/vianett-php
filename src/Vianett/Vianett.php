<?php

namespace zaporylie\Vianett;

use Http\Client\Exception\HttpException;
use Http\Client\Exception\NetworkException;
use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;

class Vianett implements VianettInterface
{

    protected $client;

    protected $username;

    protected $password;

    /**
     * @var \Http\Message\MessageFactory
     */
    protected $messageFactory;

    public function __construct($client, $username, $password)
    {
        $this->setHttpClient($client);
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     */
    public function setHttpClient($httpClient)
    {
        if (!($httpClient instanceof HttpAsyncClient || $httpClient instanceof HttpClient)) {
            throw new \LogicException(sprintf(
              'Parameter to Vianett::setHttpClient must be instance of "%s" or "%s"',
              HttpClient::class,
              HttpAsyncClient::class
            ));
        }
        $this->httpClient = $httpClient;
        return $this;
    }

    public function messages()
    {
        return new Message($this);
    }

    public function request($method, $uri, array $payload = [])
    {
        try {
            // Build request.
            $request = $this->buildRequest($method, $uri, $payload);
            // Make a request.
            $response = $this->client->sendRequest($request);
            // Get and decode content.
            $content = json_decode($response->getBody()->getContents());
            // If everything is ok return content.
            return $content;
        } catch (HttpException $e) {
            $exception = new Exception($e->getMessage(), $e->getCode(), $e);
            $content = json_decode($e->getResponse()->getBody()->getContents());
            throw $exception;
        } catch (NetworkException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Return request for method
     *
     * @param $method
     * @param $uri
     * @param array $payload
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function buildRequest($method, $uri, array $payload)
    {
        return $this->getMessageFactory()->createRequest(
          $method,
          $this->getUri($uri),
          $this->getHeaders($method),
          $this->getPayload($payload)
        );
    }

    /**
     * @param $uri
     *
     * @return string
     */
    protected function getUri($uri)
    {
        $base_uri = $this->environment->getUri();
        return sprintf('%s/%s%s', $base_uri, $this->version, $uri);
    }

    /**
     * Get request headers.
     *
     * @param string $method
     *
     * @return array
     */
    protected function getHeaders($method)
    {
        $headers = [
          'Content-Type' => 'application/json',
        ];
        return $headers;
    }

    /**
     * Get request payload.
     *
     * @param array $payload
     *
     * @return string
     */
    protected function getPayload(array $payload)
    {
        $payload = array_merge_recursive($payload, [
          'merchantInfo' => [
            'merchantSerialNumber' => $this->merchantSerialNumber,
          ],
        ]);
        return json_encode($payload, JSON_UNESCAPED_SLASHES);
    }

    /**
     * @return \Http\Message\MessageFactory
     */
    protected function getMessageFactory()
    {
        if (!$this->messageFactory) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }
        return $this->messageFactory;
    }
}
