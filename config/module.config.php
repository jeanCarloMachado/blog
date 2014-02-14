<?php
return array(

    'controllers' => array(
        'invokables' => array(
           "AckUsers\Controller\Usuarios" => "AckUsers\Controller\UsuariosController",
           "AckUsers\Controller\Gruposdeusuarios" => "AckUsers\Controller\GruposdeusuariosController",
           "AckUsers\Controller\Permissoesdegrupos" => "AckUsers\Controller\PermissoesdegruposController",
           "AckUsers\Controller\deletar" => "AckUsers\Controller\deletarController",
           "AckUsers\Controller\Perfil" => "AckUsers\Controller\PerfilController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(

            'perfil' => array (
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/usuarios/:action',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'ControlaCar\Controller',
                        "controller" => "Usuarios",
                        'action' => "perfil"
                      ),
                ),
            ),

            'usuarios' => array(
                'type'    => 'Segment',
                 'options' => array(
                    'route'    => '/usuarios/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'ControlaCar\Controller',
                        "controller" => "Usuarios",
                        'action' => "lista"
                    ),
                ),
            ),

           'alterar-senha' => array (
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/usuarios/alterarsenha',
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckUsers\Controller',
                        "controller" => "Usuarios",
                        'action' => "alterarsenha"
                    ),
                ),
            ),

           'logoff' => array (
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/usuarios/logoff',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'ControlaCar\Controller',
                        "controller" => "Usuarios",
                        'action' => "logoff"
                    ),
                ),
            ),

           'login' => array (
                'type'    => 'Literal',
                'priority' => 667,
                'options' => array(
                    'route'    => '/usuarios/login',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckUsers\Controller',
                        "controller" => "Usuarios",
                        'action' => "login"
                    ),
                ),
            ),

           'login-reciver' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/usuarios/login',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'ControlaCar\Controller',
                        "controller" => "Usuarios",
                        'action' => "login"
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
            'AckUsuarios' => __DIR__ . '/../view',
            'AckUsers' => __DIR__ . '/../view',
        ),
    ),
);
