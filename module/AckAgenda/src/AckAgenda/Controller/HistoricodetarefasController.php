<?php
namespace AckAgenda\Controller;
use System\Mvc\Controller\TableRowAutomatorAbstract;
class HistoricodetarefasController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckAgenda\Model\TasksHistorys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Historico";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );
}
