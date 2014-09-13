<?php
return array(
    'controllers' => array(
        'invokables' => array(
           "AckAgenda\Controller\Frequencias" => "AckAgenda\Controller\FrequenciasController",
           "AckAgenda\Controller\Tarefas" => "AckAgenda\Controller\TarefasController",
           "AckAgenda\Controller\Historicodetarefas" => "AckAgenda\Controller\HistoricodetarefasController",
           "AckAgenda\Controller\Diarios" => "AckAgenda\Controller\DiariosController",
           "AckAgenda\Controller\Lembretes" => "AckAgenda\Controller\LembretesController",
           "AckAgenda\Controller\Agendamentos" => "AckAgenda\Controller\AgendamentosController",
           //#NEW_CONTROLLERS_HERE_DO_NOT_REMOVE_THIS
        ),
    ),
    'router' => array(
        'routes' => array(

            'agendamentos' => array(
                'type'    => 'Segment',
                'priority' => 666,
                 'options' => array(
                    'route'    => '/agendamentos/:action[/:id][/:params]',
                    'constraints' => array(
                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'params' => '(.*)'
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'AckAgenda\Controller',
                        "controller" => 'Agendamentos',
                        'action' => "lista"
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
            'AckAgenda' => __DIR__ . '/../view',
        ),
    ),
);
