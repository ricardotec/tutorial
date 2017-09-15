<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir,
        $config->application->libraryDir,
        $config->application->formsDir
    ]
)->register();

// Register some classes
$loader->registerFiles(
    [
        'pclzip.lib.php',
    ]
);

// Register autoloader
$loader->register();
