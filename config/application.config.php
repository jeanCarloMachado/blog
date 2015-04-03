<?php
$config =  array(
      "modules" => array (
        'SiteJean',
        'AckCore',
        'AckDb',
        'AckMvc',
        'AckUsers',
        'AckCmd',
        'AckLocale',
        'AckContent',
        'AckContact',
        'AckBlog',
        'AckCEO',
        'AckCMS',
        'DluTwBootstrap'
    ),#ENDMODULES_HASH

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

if (!getenv('APPLICATION_ENV')  ||  getenv('APPLICATION_ENV') == 'development') {
}

return $config;
