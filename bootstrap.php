<?php

error_reporting(E_ALL);

// Constants
define('APP_ROOT', __DIR__);
define('WEB_ROOT', __DIR__.'/web');

require APP_ROOT.'/vendor/autoload.php';

// Register simplest PSR-4 autoloader
spl_autoload_register(function ($className)
{
    $file = APP_ROOT.'/'.str_replace('\\', '/', $className).'.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
    return false;
});