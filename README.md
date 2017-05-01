# Vianett PHP SDK
[![Build Status](https://travis-ci.org/zaporylie/vianett-php.svg?branch=master)](https://travis-ci.org/zaporylie/vianett-php)[![Coverage Status](https://coveralls.io/repos/github/zaporylie/vianett-php/badge.svg?branch=master)](https://coveralls.io/github/zaporylie/vianett-php?branch=master)

PHP API wrapper for Vianett SMS gateway.

> ViaNett was founded on 24 January 1998 to enable high-performance businesses to bridge the communication environment between end-users, groups and companies "via the net".
> ViaNett is a fast-growing organization focusing on highly scalable technologies like SMS applications, Content Management Systems and an on-line shopping application. Its technologies have a proven record of delivering value to a great variety of business enterprises.

## Installation

```bash
composer require zaporylie/vianett
```

or add it to composer.json manually:

```json
    "require": {
        "zaporylie/vianett": "^1.0"
    }
```

## Quickstart

For advanced usage example check <root>/examples

```php
// Create Vianett client.
$vianett = new \zaporylie\Vianett\Vianett(
    'username',
    'password'
);

// Get message handler.
$message = $vianett->messageFactory();

// Send message.
$response = $message->send(
    'sender',
    'recipient',
    'message'
);
```

## Credits

Jakub Piasecki
