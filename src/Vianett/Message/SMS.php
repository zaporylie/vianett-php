<?php

namespace zaporylie\Vianett\Message;

use \InvalidArgumentException;
use libphonenumber\PhoneNumberUtil;

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
     *
     */
    const SENDER_TYPE_MSISDN = 1;
    const SENDER_TYPE_SHORT_CODE = 2;
    const SENDER_TYPE_ALPHANUMERIC = 5;

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
        // Validate sender.
        $type = $options['SenderAddressType'] ? $options['SenderAddressType'] : self::SENDER_TYPE_ALPHANUMERIC;
        $this->validateSenderNumber($type, $sender);

        // Build params array.
        $options = [
          'SenderAddress' => $sender,
          'Tel' => $recipient,
          'msg' => $message,
        ] + $options;

        // Add and null all available parameters.
        $options += [
          'msgid' => null,
          'SenderAddressType' => $type,
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

    /**
     * @param $type
     * @param $sender
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function validateSenderNumber($type, $sender)
    {
        switch ($type) {
            case self::SENDER_TYPE_ALPHANUMERIC:
                // Validate number's length.
                if (strlen($sender) > 11) {
                    throw new InvalidArgumentException('Sender address cannot be longer than 11 characters.');
                }
                return true;

            case self::SENDER_TYPE_SHORT_CODE:
                // Validate short code number.
                try {
                    $phoneNumberUtils = PhoneNumberUtil::getInstance();
                    $number = $phoneNumberUtils->parse($sender, null);
                } catch (\Exception $e) {
                    throw new InvalidArgumentException($e->getMessage(), 0, $e);
                }

                $shortNumberUtil = \libphonenumber\ShortNumberInfo::getInstance();
                if (!$shortNumberUtil->isValidShortNumber($number)) {
                    throw new InvalidArgumentException('Invalid short phone number');
                }
                return true;

            case self::SENDER_TYPE_MSISDN:
                // Validate phone number.
                try {
                    $phoneNumberUtils = PhoneNumberUtil::getInstance();
                    $number = $phoneNumberUtils->parse($sender, null);
                } catch (\Exception $e) {
                    throw new InvalidArgumentException($e->getMessage(), 0, $e);
                }

                if (!$phoneNumberUtils->isValidNumber($number)) {
                    throw new InvalidArgumentException('Invalid phone number');
                }
                return true;

            default:
                throw new InvalidArgumentException('Invalid SenderAddressType value');
        }
    }
}
