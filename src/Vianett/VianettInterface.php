<?php

namespace zaporylie\Vianett;

interface VianettInterface
{

    /**
     * @param \zaporylie\Vianett\ResourceInterface $resource
     * @param array $data
     *
     * @return mixed
     */
    public function request(ResourceInterface $resource, array $data = []);
}
