<?php

namespace zaporylie\Vianett\Message;

class SMS extends MessageBase
{

    /**
     * Base Url.
     */
    const HOST = 'https://smsc.vianett.no/v3';

    /**
     * Request method.
     */
    const METHOD = 'POST';

    /**
     * Endpoint uri.
     */
    const URI = 'send';

    /**
     * {@inheritdoc}
     */
    public static function getBaseUrl()
    {
        return self::HOST;
    }

    /**
     * {@inheritdoc}
     */
    public static function getMethod()
    {
        return self::METHOD;
    }

    /**
     * {@inheritdoc}
     */
    public static function getUri()
    {
        return self::URI;
    }

    /**
     * {@inheritdoc}
     *
     * @see https://www.vianett.com/en/developers/api-documentation/http-get-post-api
     */
    public function send($sender, $recipient, $message, $options = [])
    {
        // Build params array.
        $options = [
          'SenderAddress' => $sender,
          'Tel' => $recipient,
          'msg' => $message,
        ] + $options;

        // Add and null all available parameters.
        $options += [
          'msgid' => null,
          'SenderAddressType' => null,
          'msgbinary' => null,
          'msgheader' => null,
          'ReplyPathValue' => null,
          'ReplypathID' => null,
          'ScheduledDate' => null,
          'ScheduledSMSCDate' => null,
          'ReferenceID' => null,
          'CheckForDuplicates' => null,
          'MMSdata' => null,
          'mmsurl' => null,
          'PriceGroup' => null,
          'CampaignID' => null,
          'TeleOp' => null,
          'Nrq' => null,
          'Priority' => null,
        ];

        return $this->vianett->request($this, $options);
    }
}
