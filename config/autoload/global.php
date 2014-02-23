<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
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

    "content_managed_controllers" => array(
                "\AckCore\Controller\DadosgeraisController",
                "\AckContent\Controller\InstitucionalController",
                "\AckCore\Controller\ModulosController",
                "\AckLocale\Controller\EnderecosController",
                "\AckContact\Controller\ContatosController",
                "\AckProducts\Controller\ProdutosController",
                "\AckContent\Controller\ConteudosController",
                "\AckCore\Controller\DashboardController",
                "\AckProducts\Controller\CategoriasdeprodutosController",
                "\AckProducts\Controller\ServicosController",
                "\AckContent\Controller\TextosController",
                "\AckContact\Controller\CurriculosController",
                "\AckSales\Controller\OrcamentosController",
                "\AckContent\Controller\DestaquesController",
                "\AckSales\Controller\StatusorcamentosController",
                "\AckContent\Controller\TextosController",
                "\AckUsers\Controller\UsuariosController",
                "\AckCore\Controller\LogsController",
                "\AckAgenda\Controller\TarefasController",
    )

);
