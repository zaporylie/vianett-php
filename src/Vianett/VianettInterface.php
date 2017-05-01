<?php

namespace zaporylie\Vianett;

interface VianettInterface
{

    /**
     * Inject http client.
     *
     * @param \Http\Client\HttpClient|\Http\Client\HttpAsyncClient $client
     *
     * @return \zaporylie\Vianett\VianettInterface
     */
    public function setHttpClient($client);

    /**
     * Perform request.
     *
     * @param \zaporylie\Vianett\ResourceInterface $resource
     * @param array $data
     *
     * @return mixed
     */
    public function request(ResourceInterface $resource, array $data = []);

    /**
     * Get message interface.
     *
     * @param string $type
     *
     * @return \zaporylie\Vianett\Message\MessageInterface
     */
    public function messageFactory($type = 'SMS');
}
