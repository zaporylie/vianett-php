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
    public static function getMethod();
    public static function getUri();
}
