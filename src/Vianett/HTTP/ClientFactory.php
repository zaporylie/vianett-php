<?php

namespace zaporylie\Vianett\HTTP;

use Http\Client\HttpAsyncClient;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;

class ClientFactory
{
    /**
     * @param null|HttpClient|HttpAsyncClient $client
     *
     * @return HttpClient|HttpAsyncClient
     */
    public static function get($client = null)
    {
        if (isset($client) && ($client instanceof HttpAsyncClient || $client instanceof HttpClient)) {
            return $client;
        } elseif (isset($client)) {
            throw new \LogicException(sprintf(
                'HttpClient must be instance of "%s" or "%s"',
                HttpClient::class,
                HttpAsyncClient::class
            ));
        }
        return HttpClientDiscovery::find();
    }
}
