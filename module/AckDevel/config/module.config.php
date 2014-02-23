<?php
return array(
 'controllers' => array(
    'invokables' => array(
           "AckDevel\Controller\Dashboard" => "AckDevel\Controller\DashboardController",
           "AckDevel\Controller\Scriptsbanco" => "AckDevel\Controller\ScriptsbancoController",
           "AckDevel\Controller\Testes" => "AckDevel\Controller\TestesController",
           "AckDevel\Controller\Confusuarios" => "AckDevel\Controller\ConfusuariosController",
           "AckDevel\Controller\Relations" => "AckDevel\Controller\RelationsController",
           "AckDevel\Controller\TableModels" => "AckDevel\Controller\TableModelsController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    //========================= rotas de console =========================
    "console" => array(
        'router' => array(
            'routes' => array(
                'Relations' => array(
                  //  'type'    => 'Literal',
                    'options' => array(
                        // Change this to something specific to your module
                        'route'    => 'relations [<action>] [<parameters>]',
                        'defaults' => array(
                            // Change this value to reflect the namespace in which
                            // the controllers for your module are found
                            '__NAMESPACE__' => 'AckDevel\Controller',
                            'controller'    => 'Relations',
                            'action'        => 'index',
                        ),
                    ),
                ),
                'TableModels' => array(
                  //  'type'    => 'Literal',
                    'options' => array(
                        // Change this to something specific to your module
                        'route'    => 'table-models [<action>] [<parameters>]',
                        'defaults' => array(
                            // Change this value to reflect the namespace in which
                            // the controllers for your module are found
                            '__NAMESPACE__' => 'AckDevel\Controller',
                            'controller'    => 'TableModels',
                            'action'        => 'index',
                        ),
                    ),
                ),
            ),
        ),
    ),
    //======================= END rotas de console =======================

 'router' => array(
    'routes' => array(
          'AckConfUsuarios' => array(
            'type'    => 'Literal',
            'options' => array(
                    // Change this to something specific to your module
                'route'    => '/ack/confusuarios',
                'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                    '__NAMESPACE__' => 'AckDevel\Controller',
                    'controller'    => 'Confusuarios',
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
                        'route'    => '[/][:action][/:id][/:params]',
                        'constraints' => array(
                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                            'params' => '(.*)'
                            ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckDevel\Controller',
                            'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
        'AckScriptsBanco' => array(
            'type'    => 'Literal',
            'options' => array(
                    // Change this to something specific to your module
                'route'    => '/ack/scriptsbanco',
                'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                    '__NAMESPACE__' => 'AckDevel\Controller',
                    'controller'    => 'Scriptsbanco',
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
                        'route'    => '[/][:action][/:id][/:params]',
                        'constraints' => array(
                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                            'params' => '(.*)'
                            ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckDevel\Controller',
                            'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
                 'AckTestes' => array(
            'type'    => 'Literal',
            'options' => array(
                    // Change this to something specific to your module
                'route'    => '/ack/testes',
                'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                    '__NAMESPACE__' => 'AckDevel\Controller',
                    'controller'    => 'Testes',
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
                        'route'    => '[/][:action][/:id][/:params]',
                        'constraints' => array(
                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                            'params' => '(.*)'
                            ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckDevel\Controller',
                            'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
        'AckDevel' => array(
            'type'    => 'Literal',
            'options' => array(
                    // Change this to something specific to your module
                'route'    => '/ack/devel',
                'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                    '__NAMESPACE__' => 'AckDevel\Controller',
                    'controller'    => 'Dashboard',
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
                         'route'    => '[/][:controller][/][:action][/:id][/:params]',
                        'constraints' => array(
                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                            'params' => '(.*)'
                            ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckDevel\Controller',
                            'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
        ),
       ),

   'view_manager' => array
  (
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_path_stack' => array
        (
            'AckDevel' => __DIR__ . '/../view',
        ),
    ),

);
