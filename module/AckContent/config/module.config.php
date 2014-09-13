<?php
return array(
    'controllers' => array(
        'invokables' => array(
           // //"#DISABLE_CONTROLLER_BY_SCRIPTAckContent\Controller\Destaques" => "AckContent\Controller\DestaquesController",
           // "AckContent\Controller\Institucional" => "AckContent\Controller\InstitucionalController",
           // "AckContent\Controller\Textos" => "AckContent\Controller\TextosController",
           // "AckContent\Controller\Conteudos" => "AckContent\Controller\ConteudosController",
           //  'AckContent\Controller\Dashboard' => 'AckContent\Controller\DashboardController',
           // "AckContent\Controller\Categoriasinstitucional" => "AckContent\Controller\CategoriasinstitucionalController",
           "AckContent\Controller\Textosdeajuda" => "AckContent\Controller\TextosdeajudaController",
           "AckContent\Controller\Categoriasdetextosdeajuda" => "AckContent\Controller\CategoriasdetextosdeajudaController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(
            'textosdeajuda' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/textosdeajuda/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContent\Controller',
                        "controller" => 'Textosdeajuda',
                        'action' => "lista"
                    ),
                ),
            ),

            'categoriasdetextosdeajuda' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/categoriasdetextosdeajuda/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContent\Controller',
                        "controller" => 'Categoriasdetextosdeajuda',
                        'action' => "lista"
                    ),
                ),
            ),

            'visualizacaoajudas' => array(
                'type'    => 'Literal',
                'priority' => 667,
                 'options' => array(
                    'route'    => '/textosdeajuda/index',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContent\Controller',
                        "controller" => 'Textosdeajuda',
                        'action' => "index"
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
            'AckContent' => __DIR__ . '/../view',
        ),
    ),
);
