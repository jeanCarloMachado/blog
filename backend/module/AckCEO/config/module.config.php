 <?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AckCEO\Controller\Metatags' => "AckCEO\Controller\MetatagsController",
        ),
    ),
    'router' => array(
        'routes' => array(
		
		'metatags' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/metatags/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckCEO\Controller',
                        "controller" => 'Metatags',
                        'action' => "lista"
                    ),
	    ),
	    ), 
    ),
    ),
);
