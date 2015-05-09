<?php
return array(
    'controllers' => array(
        'invokables' => array(
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(
            //coloque aqui suas rotas
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
            'AckMvc' => __DIR__ . '/../view',
        ),
    ),
//###################################################################################
//################################# END ViewManager básica########################################
//###################################################################################
);
