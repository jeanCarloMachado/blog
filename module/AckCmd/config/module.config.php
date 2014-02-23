<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AckCmd\Controller\Index' => 'AckCmd\Controller\IndexController',
            'AckCmd\Controller\Mvc' => 'AckCmd\Controller\MvcController',
            'AckCmd\Controller\Help' => 'AckCmd\Controller\HelpController',
            'AckCmd\Controller\Translate' => 'AckCmd\Controller\TranslateController',
            'AckCmd\Controller\Install' => 'AckCmd\Controller\InstallController',
            'AckCmd\Controller\Modules' => 'AckCmd\Controller\ModulesController',
            'AckCmd\Controller\Create' => 'AckCmd\Controller\CreateController',
            'AckCmd\Controller\Controller' => 'AckCmd\Controller\ControllerController',
            'AckCmd\Controller\Pfc' => 'AckCmd\Controller\PfcController',
            'AckCmd\Controller\Cron' => 'AckCmd\Controller\CronController',
            //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    "console" => array(
        'router' => array(
            'routes' => array(
                'AckCmd' => array(
                  //  'type'    => 'Literal',
                    'options' => array(
                        // Change this to something specific to your module
                        'route'    => '[<controller>] [<action>] [<parameters>]',
                        'defaults' => array(
                            // Change this value to reflect the namespace in which
                            // the controllers for your module are found
                            '__NAMESPACE__' => 'AckCmd\Controller',
                            'controller'    => 'Index',
                            'action'        => 'index',
                        ),
                    ),
                ),

            // 'registerController' => array(
            //     "type" => "literal",
            //     //'priority' => 999,
            //     'options' => array(
            //         'route' => 'mvc registerController <fullControllerName> <moduleNamespace>',
            //         'defaults' => array(
            //             'controller' => 'AckCmd\Controller\Mvc',
            //             'action' => 'registerController',
            //         )
            //     )
            // ),

            ),
        ),
    ),
);
