<?php

namespace zaporylie\Vianett\Message;

interface MessageInterface
{
    /**
     * @param string $sender
     * @param string $recipient
     * @param string $message
     * @param array $options
     *
     * @return mixed
     */
    public function send($sender, $recipient, $message, $options = []);
}
