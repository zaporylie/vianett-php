# Vianett PHP SDK
[![Build Status](https://travis-ci.org/zaporylie/vianett-php.svg?branch=master)](https://travis-ci.org/zaporylie/vianett-php)[![Coverage Status](https://coveralls.io/repos/github/zaporylie/vianett-php/badge.svg?branch=master)](https://coveralls.io/github/zaporylie/vianett-php?branch=master)

A PHP library for the ViaNett API

## Installation

`composer require zaporylie/vianett-php:dev-master`

or add it to composer.json manually:

```
  "require": {
    "zaporylie/vianett-php": "dev-master"
  }
```

## Usage

```
$client = new \Vianett\Client('username', 'password');
$message = new \Vianett\Message($client);
$message->prepare('sender', 'recipient', 'message', 'message_id');
$message->send();
```

## Credits

Jakub Piasecki for NyMedia AS
