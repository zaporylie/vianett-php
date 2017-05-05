<?php

namespace zaporylie\Vianett\Message;

use zaporylie\Vianett\ResourceInterface;
use zaporylie\Vianett\VianettInterface;

abstract class MessageBase implements ResourceInterface, MessageInterface
{

    /**
     * VianettInterface object.
     *
     * @var \zaporylie\Vianett\VianettInterface
     */
    protected $vianett;

    /**
     * MessageBase constructor.
     *
     * @param \zaporylie\Vianett\VianettInterface $vianett
     */
    public function __construct(VianettInterface $vianett)
    {
        $this->vianett = $vianett;
    }

    /**
     * {@inheritdoc}
     */
    public function send($sender, $recipient, $message, $options = [])
    {
        throw new \Exception('Undefined method: send');
    }
}
