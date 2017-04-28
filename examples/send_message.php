<?php
include __DIR__ . '/../vendor/autoload.php';
$yaml = new \Symfony\Component\Yaml\Parser();
$settings = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/settings.yml'));
try {
  $httpClient = new Http\Adapter\Guzzle6\Client(new \GuzzleHttp\Client());
  $vipps = new \zaporylie\Vianett\Vianett($httpClient);
  $vipps->setUsername($settings['username']);
  $vipps->setPassword($settings['password']);

  $message = $vipps->messages();

  // Get transaction status.
  $message->send(
    $settings['destination'],
    $settings['message'],
    $settings['sender']
  );

  // Dump last response.
  var_dump($message->getLastResponse());
}
catch (Exception $e) {
  print '<pre>' . var_dump($e) . '</pre>';
}