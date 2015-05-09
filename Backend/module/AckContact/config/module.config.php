<?php
return array(
    'controllers' => array(
        'invokables' => array(
           "AckContact\Controller\Categoriasfaq" => "AckContact\Controller\CategoriasfaqController",
           "AckContact\Controller\Faq" => "AckContact\Controller\FaqController",
           "AckContact\Controller\Contatoscategorias" => "AckContact\Controller\ContatoscategoriasController",
           "AckContact\Controller\Curriculoscategorias" => "AckContact\Controller\CurriculoscategoriasController",
           "AckContact\Controller\Emailsdosistema" => "AckContact\Controller\EmailsdosistemaController",
           "AckContact\Controller\Mensagens" => "AckContact\Controller\MensagensController",
           "AckContact\Controller\Notificacoes" => "AckContact\Controller\NotificacoesController",
           "AckContact\Controller\Contatosimples" => "AckContact\Controller\ContatosimplesController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(
            'mensagens' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/mensagens/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContact\Controller',
                        "controller" => 'Mensagens',
                        'action' => "lista"
                    ),
                ),
            ),
           
            'contatosimples' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/contatosimples/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContact\Controller',
                        "controller" => 'Contatosimples',
                        'action' => "lista"
                    ),
                ),
            ),


            'contatar' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/contato',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContact\Controller',
                        "controller" => 'Contatosimples',
                        'action' => "contatar"
                    ),
                ),
            ),
            'notificacoes' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/notificacoes/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContact\Controller',
                        "controller" => 'Notificacoes',
                        'action' => "lista"
                    ),
                ),
            ),

            'minhasnotificacoes' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/usuarios/perfil/minhasnotificacoes',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckContact\Controller',
                        "controller" => 'Notificacoes',
                        'action' => "minhasnotificacoes"
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
            'AckContact' => __DIR__ . '/../view',
        ),
    ),
);
