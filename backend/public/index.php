<?php

if (isset($_SERVER['REQUEST_METHOD'])
    && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

date_default_timezone_set('America/Sao_Paulo');
chdir(dirname(__DIR__));

define('REQUEST_MICROTIME', microtime(true));

// Setup autoloading
require 'init_autoloader.php';

if (!defined('APPLICATION_PATH')) {
    define('APPLICATION_PATH', realpath(__DIR__.'/../'));
}

$appConfig = include APPLICATION_PATH.'/config/application.config.php';

if (file_exists(APPLICATION_PATH.'/config/development.config.php')) {
    $appConfig = Zend\Stdlib\ArrayUtils::merge($appConfig, include APPLICATION_PATH.'/config/development.config.php');
}

// Run the application!
Zend\Mvc\Application::init($appConfig)->run();
