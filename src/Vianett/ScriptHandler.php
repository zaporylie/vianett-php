<?php

namespace zaporylie\Vianett;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

/**
 * Class ScriptHandler
 *
 * @package zaporylie\Vianett
 */
class ScriptHandler
{
    /**
     * Generate dummy yaml.
     */
    public static function createExamplesConfigFile()
    {
        $fs = new Filesystem();
        $root = __DIR__ . '/../../';
        if (!$fs->exists($root . 'examples/settings.yml')) {
            $settings = [
                'username' => '',
                'password' => '',
                'sender' => '',
                'recipient' => '',
                'message' => '',
            ];
            $content = Yaml::dump($settings);
            $fs->dumpFile($root . 'examples/settings.yml', $content);
        }
    }
}
