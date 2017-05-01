<?php

namespace zaporylie\Vianett;

interface ResourceInterface
{
    /**
     * No trailing slashes!
     *
     * @return string
     */
    public static function getBaseUrl();

    /**
     * Request method.
     *
     * @return string
     */
    public static function getMethod();

    /**
     * Request URI.
     *
     * @return string
     */
    public static function getUri();
}
