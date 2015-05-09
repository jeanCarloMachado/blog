<?php
return array(
    'ack' => array (
        'emailLogo' => '/#sitename#/imagens/email/logo.png',
    ),
    'controllers' => array(
        'invokables' => array(
           'AckCore\Controller\ServicesProvider' => 'AckCore\Controller\ServicesproviderController',
           'AckCore\Controller\Configuracoes' => 'AckCore\Controller\ConfiguracoesController',
        ),
    ),
    'router' => array(
        'routes' => array(
               'ack' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/ack',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckCore\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
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
                                'controller' => 'index',
                                'action' => 'index'
                            ),
                        ),
                    ),
                ),
            ),
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
                        'controller' => 'ServicesProvider',
                        'action' => 'lista'
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
            'error/index' => __DIR__ . '/../view/ack-core/error/index.phtml',
            'error/404' => __DIR__ . '/../view/ack-core/error/404.phtml'
        ),
        'template_path_stack' => array(
            'AckCore' => __DIR__ . '/../view',
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'invokables' => array(
            'pluralizer' => '\AckCore\View\Helper\Pluralizer',
            'AckCore\Model\Visits' => 'AckCore\Model\Visits'
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
