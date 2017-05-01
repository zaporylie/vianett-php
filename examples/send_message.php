<?php
include __DIR__ . '/../vendor/autoload.php';
$yaml = new \Symfony\Component\Yaml\Parser();
$settings = \Symfony\Component\Yaml\Yaml::parse(file_get_contents(__DIR__.'/settings.yml'));

try {
    $vianett = new \zaporylie\Vianett\Vianett($settings['username'], $settings['password']);
    $message = $vianett->messageFactory();
        // Get transaction status.
        $message->send(
            $settings['sender'],
            $settings['recipient'],
            $settings['message']
        );

    /*
        // Dump last response.
        var_dump($message->getLastResponse());
    */
}
catch (Exception $e) {
    print '<pre>' . var_dump($e) . '</pre>';
}
