<?php
namespace AckAgenda\Model;
use AckDb\ZF1\TableAbstract as Table;
class TasksHistorys extends Table
{
    protected $relations = array(	"1:n" => array(	array("model" => "\SiteJean\Model\Usuarios", "reference" => "usuario_id", "elementTitle" => "Usuario", "relatedRowUrlTemplate" => "/usuarios/editar/{id}")));
    protected $meta = array(
        "humanizedIdentifier" => "data",
   );
    protected $colsNicks = array("tarefa_id" => "Tarefa", "usuario_id" => "Usuário", "usuario_concluinte_id" => "Usuário Concluinte", "data" => "Data"
    );

    protected $_name = "ack_tarefas_historico";
    protected $_row = "\AckAgenda\Model\TasksHistory";

    const moduleName = "TasksHistory";
    const moduleId = 52;
}
