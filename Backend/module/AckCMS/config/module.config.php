 <?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AckCMS\Controller\Configuracoes' => 'AckCMS\Controller\ConfiguracoesController',
        ),
    ),
    'router' => array(
        'routes' => array(
		
		'configuracoes' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/configuracoes[/:action][/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckCMS\Controller',
                        'controller' => 'Configuracoes',
                        'action' => 'configuracoes'
                    ),
            ),
	    ), 
    ),
    ),
);
