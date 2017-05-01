<?php

namespace zaporylie\Vianett;

use function GuzzleHttp\Psr7\build_query;
use Http\Client\Exception\NetworkException;
use Http\Discovery\MessageFactoryDiscovery;
use Psr\Http\Message\ResponseInterface;
use zaporylie\Vianett\HTTP\ClientFactory;
use zaporylie\Vianett\Message\SMS;

class Vianett implements VianettInterface
{

    /**
     * @var \Http\Client\HttpClient|\Http\Client\HttpAsyncClient
     */
    protected $client;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \Http\Message\MessageFactory
     */
    protected $messageFactory;

    /**
     * Vianett constructor.
     *
     * @param string $username
     * @param string $password
     * @param array $options
     */
    public function __construct($username, $password, $options = [])
    {
        $this->username = $username;
        $this->password = $password;

        $this->setHttpClient(isset($options['http_client']) ? $options['http_client'] : null);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \LogicException
     */
    public function setHttpClient($httpClient)
    {
        $this->client = ClientFactory::get($httpClient);
        unset($this->messageFactory);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function messageFactory($type = 'SMS')
    {
        switch ($type) {
            case 'SMS':
                return new SMS($this);
        }
        throw new \InvalidArgumentException('Invalid message type');
    }

    /**
     * {@inheritdoc}
     */
    public function request(ResourceInterface $resource, array $content = [])
    {
        try {
            // Build request.
            $request = $this->buildRequest($resource, $content);
            // Make a request.
            $response = $this->client->sendRequest($request);
            // Parse response.
            return $this->parseResponse($response);
        } catch (NetworkException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return mixed
     * @throws \zaporylie\Vianett\Exception
     */
    protected function parseResponse(ResponseInterface $response)
    {
        $success = $response->getHeader('Success');
        $error_code = $response->getHeader('Error-Code');
        $error_description = $response->getHeader('Error-Desc');

        // Get status.
        if (is_array($success)) {
            $success = reset($success);
        }

        // Get code.
        if (is_array($error_code)) {
            $error_code = (int) reset($error_code);
        }

        // Get description.
        if (is_array($error_description)) {
            $error_description = reset($error_description);
        }

        // If code is not equal 200, request have failed.
        if ($success == 'true') {
            return $response->getBody()->getContents();
        }

        throw new Exception($error_description, $error_code);
    }

    /**
     * Return request for method
     *
     * @param ResourceInterface $resource
     * @param array data
     *
     * @return \Psr\Http\Message\RequestInterface
     */
    protected function buildRequest(ResourceInterface $resource, array $data)
    {
        return $this->messageFactoryDiscovery()->createRequest(
            $resource->getMethod(),
            $this->getUri($resource),
            $this->getHeaders($resource),
            $this->getData($resource, $data)
        );
    }

    /**
     * @param ResourceInterface $resource
     *
     * @return string
     */
    protected function getUri(ResourceInterface $resource)
    {
        return sprintf('%s/%s', $resource->getBaseUrl(), $resource->getUri());
    }

    /**
     * Get request headers.
     *
     * @param ResourceInterface $resource
     *
     * @return array
     */
    protected function getHeaders(ResourceInterface $resource)
    {
        $headers = [
          'Content-Type' => 'application/x-www-form-urlencoded',
        ];
        return $headers;
    }

    /**
     * Build request data.
     *
     * @param \zaporylie\Vianett\ResourceInterface $resource
     * @param array $data
     *
     * @return string
     */
    protected function getData(ResourceInterface $resource, array $data)
    {
        $data = [
          'username' => $this->username,
          'password' => $this->password,
        ] + $data;
        $data = array_filter($data);
        return build_query($data);
    }

    /**
     * @return \Http\Message\MessageFactory
     */
    protected function messageFactoryDiscovery()
    {
        if (!isset($this->messageFactory)) {
            $this->messageFactory = MessageFactoryDiscovery::find();
        }
        return $this->messageFactory;
    }
}
