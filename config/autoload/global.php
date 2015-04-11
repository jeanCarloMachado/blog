<?php
return array(
    "debug" => false,
    'db' => array(
        'driver'         => 'Mysqli',
        'dbname' => "ack_default",
        "host" => "localhost",
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Db\Adapter\Adapter'
                    => 'Zend\Db\Adapter\AdapterServiceFactory',
        ),
    ),
);
