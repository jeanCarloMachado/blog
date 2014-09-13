<?php
return array(
 'controllers' => array(
    'invokables' => array(
        'AckProducts\Controller\Produtos' => 'AckProducts\Controller\ProdutosController',
        'AckProducts\Controller\Categoriasdeprodutos' => 'AckProducts\Controller\CategoriasdeprodutosController',
        'AckProducts\Controller\Servicos' => 'AckProducts\Controller\ServicosController',
        ),
    ),

 'router' => array(
    'routes' => array(
        'AckProductsProducts' => array(
            'type'    => 'Literal',
            'options' => array(
                    // Change this to something specific to your module
                'route'    => '/ack/produtos',
                'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                    '__NAMESPACE__' => 'AckProducts\Controller',
                    'controller'    => 'Produtos',
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
                            '__NAMESPACE__' => 'AckProducts\Controller',
                            'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),  
             
        //###################################################################################
        //################################# rota  de categoria de produtos###########################################
        //###################################################################################
           'AckProductsCategorys' => array(
            'type'    => 'Literal',
            'options' => array(
                    // Change this to something specific to your module
                'route'    => '/ack/categoriasdeprodutos',
                'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                    '__NAMESPACE__' => 'AckProducts\Controller',
                    'controller'    => 'Categoriasdeprodutos',
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
                            '__NAMESPACE__' => 'AckProducts\Controller',
                            'action' => "index"
                            ),
                        ),
                    ),
                ),
            ),
        //###################################################################################
        //################################# END rota  de categoria de produtos########################################
        //###################################################################################
      //###################################################################################
        //################################# ROTA servicos ###########################################
        //###################################################################################
          'servicos' => array(
            'type'    => 'Literal',
            'options' => array(
                // Change this to something specific to your module
                'route'    => '/ack/servicos',
                'defaults' => array(
                    // Change this value to reflect the namespace in which
                    // the controllers for your module are found
                    '__NAMESPACE__' => 'AckProducts\Controller',
                    'controller'    => 'Servicos',
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
                            '__NAMESPACE__' => 'AckProducts\Controller',
                            'action' => "index"
                        ),
                    ),
                ),
            ),
        ),
        //###################################################################################
        //################################# END ROTA servicos ########################################
        //###################################################################################
        ),
    ),
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
            'AckProducts' => __DIR__ . '/../view',
        ),
    ),
//###################################################################################
//################################# END ViewManager básica########################################
//################
###################################################################
);