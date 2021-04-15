---
layout: post
title: A minimal service manager setup
---

For some time now I've been using this pattern to interact with
some services on Compufácil.

```
# !/usr/bin/env php
<?php
//file: cpf-service_manager.php
use Zend\ServiceManager\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

require __DIR__.'/../Backend/vendor/autoload.php';
$applicationConfig = require __DIR__.'/../Backend/config/application.config.php';
$serviceManager = new ServiceManager(new ServiceManagerConfig());
$serviceManager->setService('ApplicationConfig', $applicationConfig);
$serviceManager->get('ModuleManager')->loadModules();

return $serviceManager;
```

With it in hands I can simply create a file like this.

```
# !/usr/bin/env php
<?php
//file: cpf-client-remove
use Core\Service\ParameterFactory;
use Application\Service\Client\Client as ClientService;
$identifier = $argv[1];
$serviceManager = require_once __DIR__.'/cpf-service_manager.php';
$clientService = $serviceManager->get('Application\Service\Client\Client');

$where = [];
if (is_int($identifier)) {
    $where['id'] = $identifier;
} else {
    $where['email'] = $identifier;
}

$where['hash'] = ClientService::DELETE_CONFIRM_HASH;
$params = ParameterFactory::factory($where);
$clientService->delete($params);

```

So I can interact with the services easily and yet with the power of
PHP's CLI interface. I know Zend Framework has it's own Cli API, but
it's boring having to deal with routes to specify parameters. Using the
PHP's API ```argv, argv``` is much more natural IMHO.

Usually I take care to just **call** my services on this level, the logic
itself resides on the service which is covered by unit tests.
