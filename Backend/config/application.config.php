<?php
$config =  array(
      "modules" => array (
        'SiteJean',
        'AckCore',
        'AckDb',
        'AckMvc',
        'AckUsers',
        'AckLocale',
        'AckContent',
        'AckContact',
        'AckBlog',
        'AckCEO',
        'AckCMS',
        'DluTwBootstrap'
    ),

    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
        'config_glob_paths' => array(
            'config/autoload/{,*.}{global,local}.php',
        ),
    ) ,
);

return $config;
