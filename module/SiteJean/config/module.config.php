<?php
return array(
    'controllers' => array(
        'invokables' => array(
           'SiteJean\Controller\Index' => 'SiteJean\Controller\IndexController',
           'SiteJean\Controller\Dashboard' => 'SiteJean\Controller\DashboardController',
           "SiteJean\Controller\Usuarios" => "SiteJean\Controller\UsuariosController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(
            'home' => array (
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SiteJean\Controller',
                        "controller" => "Index",
                        'action' => "index"
                    ),
                ),
            ),

            'dashboard' => array (
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/dashboard',
                    'defaults' => array(
                        '__NAMESPACE__' => 'SiteJean\Controller',
                        "controller" => "Dashboard",
                        'action' => "index"
                    ),
                ),
            ),

        ),
    ),

  'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
         'template_map' => array(
            'SiteJean/layout'           => __DIR__ . '/../view/site-jean/layout/layout.phtml',
            'layout/layout'           => __DIR__ . '/../view/site-jean/layout/layout.phtml',

        ),
        'template_path_stack' => array(
            'SiteJean' => __DIR__ . '/../view',
        ),
    ),

  'service_manager' => array(
     'factories' => array(
         'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory', // <-- add this
     ),
 ),

  'navigation' => array(
     'default' => array(

        array(
            'label' => 'Home',
            'route' => 'home',
        ),

        array(
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'auth-required' => true,
        ),

        array(
            'label' => 'Usuários',
            'route' => 'usuarios',
            'auth-required' => true,
        ),

        array(
            'label' => 'Perfil',
            'route' => 'perfil',
            'auth-required' => true,

            'pages' => array(

                array(
                    'label' => 'Meu Perfil',
                    'route' => 'perfil',
                ),

                array(
                    'label' => 'Notificações',
                    'route' => 'usuarios',
                ),

                array(
                    'label' => 'Sair',
                    'route' => 'logoff',
                ),
            ),
        ),

        array(
            'label' => 'Entrar',
            'route' => 'login',
            'no-auth-required' => true,
        ),
    ),
  ),
);
