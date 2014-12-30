 <?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AckBlog\Controller\Posts' => 'AckBlog\Controller\PostsController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'posts' => array(
                    'type'    => 'Segment',
                    'priority' => 666,
                     'options' => array(
                        'route'    => '/posts/:action[/:id][/:params]',
                        'constraints' => array(
                            'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            'id'     => '[0-9]+',
                            'params' => '(.*)'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckBlog\Controller',
                            'controller' => 'Posts',
                            'action' => 'lista'
                        ),
                ),
            ),

        'view-post' => array(
                    'type'    => 'Segment',
                    'priority' => 666,
                     'options' => array(
                        'route'    => '/post/visualizar/:id[/:title]',
                        'constraints' => array(
                            'id'     => '[0-9]+',
                            'title' => '(.*)'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckBlog\Controller',
                            'controller' => 'Posts',
                            'action' => 'visualizar'
                        ),
                ),
            ),

        'json-post' => array(
                    'type'    => 'Segment',
                    'priority' => 666,
                     'options' => array(
                        'route'    => '/post/json/:id[/:title]',
                        'constraints' => array(
                            'id'     => '[0-9]+',
                            'title' => '(.*)'
                        ),
                        'defaults' => array(
                            '__NAMESPACE__' => 'AckBlog\Controller',
                            'controller' => 'Posts',
                            'action' => 'json'
                        ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'doctype'                  => 'HTML5',
         'template_path_stack' => array(
            'AckBlog' => __DIR__ . '/../view',
        ),
    ),

);
