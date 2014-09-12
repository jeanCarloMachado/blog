<?php

//In order for paths relative to your application directory to work, you must have the directive chdir(dirname(__DIR__));
chdir(dirname(__DIR__));

define('REQUEST_MICROTIME', microtime(true));
// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Zend\Mvc\Application::init(require 'config/application.config.php')->run();
