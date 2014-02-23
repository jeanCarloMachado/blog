<?php
return array(
    'controllers' => array(
        'invokables' => array(
            "AckLocale\Controller\Cidades" => "AckLocale\Controller\CidadesController",
           "AckLocale\Controller\Estados" => "AckLocale\Controller\EstadosController",
           "AckLocale\Controller\Paises" => "AckLocale\Controller\PaisesController",
           "AckLocale\Controller\Cidades" => "AckLocale\Controller\CidadesController",
           "AckLocale\Controller\Estados" => "AckLocale\Controller\EstadosController",
           "AckLocale\Controller\Enderecos" => "AckLocale\Controller\EnderecosController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
          'routes' => array(
      //###################################################################################
    //################################# ROTA enderecos ###########################################
    //###################################################################################
    'enderecos' => array(
      'type'    => 'Literal',
      'options' => array(
          // Change this to something specific to your module
          'route'    => '/ack/enderecos',
          'defaults' => array(
              // Change this value to reflect the namespace in which
              // the controllers for your module are found
              '__NAMESPACE__' => 'AckLocale\Controller',
              'controller'    => 'Enderecos',
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
                      '__NAMESPACE__' => 'AckLocale\Controller',
                      'action' => "index"
                  ),
              ),
          ),
      ),
    ),
    //###################################################################################
    //################################# END ROTA enderecos ########################################
    //###################################################################################
  //###################################################################################
  //################################# citys###########################################
  //###################################################################################
                'AckCity' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/ack/cidades',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AckLocale\Controller',
                        'controller'    => 'Cidades',
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
                                '__NAMESPACE__' => 'AckLocale\Controller',
                                'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
  //###################################################################################
  //################################# END citys########################################
  //###################################################################################
   //###################################################################################
   //################################# estados###########################################
   //###################################################################################
                 'AckEstados' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/ack/estados',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AckLocale\Controller',
                        'controller'    => 'Estados',
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
                                '__NAMESPACE__' => 'AckLocale\Controller',
                                'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
   //###################################################################################
   //################################# END estados########################################
   //###################################################################################
    'estados' => array(
                'priority' => 666,
                'type'    => 'Segment',
                 'options' => array(
                    'route'    => '/estados/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckLocale\Controller',
                        "controller" => "Estados",
                        'action' => "lista"
                    ),
                ),
            ),

            'cidades' => array(
                'priority' => 666,
                'type'    => 'Segment',
                 'options' => array(
                    'route'    => '/cidades/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckLocale\Controller',
                        "controller" => "Cidades",
                        'action' => "lista"
                    ),
                ),
            ),
    //###################################################################################
    //################################# Paises###########################################
    //###################################################################################
       'AckPaises' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/ack/paises',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'AckLocale\Controller',
                        'controller'    => 'Paises',
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
                                '__NAMESPACE__' => 'AckLocale\Controller',
                                'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),
    //###################################################################################
    //################################# END Paises########################################
    //###################################################################################

//###################################################################################
//################################# ViewManager básica###########################################
//###################################################################################
   'view_manager' => array
  (
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_path_stack' => array
        (
            'AckContact' => __DIR__ . '/../view',
        ),
    ),
//###################################################################################
//################################# END ViewManager básica########################################
//###################################################################################
);
