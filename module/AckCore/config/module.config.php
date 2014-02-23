<?php
return array(
    //configuraçoes específicas do ack
    "ack" => array (
        //logo utilizado no e-mail
        "emailLogo" => "/#sitename#/imagens/email/logo.png",
    ),
    'controllers' => array(
        'invokables' => array(
           // 'AckCore\Controller\Index' => 'AckCore\Controller\IndexController',
           // 'AckCore\Controller\Dadosgerais' => 'AckCore\Controller\DadosgeraisController',
           // 'AckCore\Controller\Logs' => 'AckCore\Controller\LogsController',
           // "AckCore\Controller\Sessaoteste" => "AckCore\Controller\SessaotesteController",
           "AckCore\Controller\ServicesProvider" => "AckCore\Controller\ServicesproviderController",
           // //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(
            //========================= rota principal =========================
               'ack' => array(
                'type'    => 'Literal',
               // 'priority' => 2,
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/ack',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AckCore\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    // This route is a sane default when developing a module;
                    // as you solidify the routes for your module, however,
                    // you may want to remove it and replace it with more
                    // specific routes.
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller][/][:action][/:id][/:params]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                                'params' => '(.*)'
                            ),
                            'defaults' => array(
                                '__NAMESPACE__' => 'AckCore\Controller',
                                "controller" => "index",
                                'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
            //======================= END rota principal =======================
            'ServicesProvider' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/servicesprovider/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckCore\Controller',
                        "controller" => 'ServicesProvider',
                        'action' => "lista"
                    ),
                ),
            ),
            ),
    ),
    'view_manager' => array(

        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
         'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
         'template_map' => array(
            //layout defautl do sistema por padrão layout/layout é renderizaod
            //'layout/layout'           => __DIR__ . '/../view/ack-core/layout/layout.phtml',
            //nome default do ack deve conter o mesmo valor que layout/layout
            'ack/layout'           => __DIR__ . '/../view/ack-core/layout/layout.phtml',
            "error/index" => __DIR__ . '/../view/ack-core/error/index.phtml',
            "error/404" => __DIR__ . '/../view/ack-core/error/404.phtml'
        ),
        'template_path_stack' => array(
            'AckCore' => __DIR__ . '/../view',
        ),
    ),
    //configura os helpers hibilitados no sistema
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
            // 'AckDb\ZF1\TableAbstract' => 'AckDb\ZF1\TableAbstract',
            // 'AckCore\Module\ZF2Mvc' => 'AckCore\Module\ZF2Mvc',
            'pluralizer' => '\AckCore\View\Helper\Pluralizer'
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
);
