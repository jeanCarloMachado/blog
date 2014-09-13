<?php
namespace AckAgenda\Controller;
use System\Mvc\Controller\TableRowAutomatorAbstract;
class FrequenciasController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckAgenda\Model\Frequencys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Frequencia";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel"),
            "elementsSettings" => array(
                                "nome" => array("orderSelector"=>true,"type"=>"TextEditor","columnSpacing"=>680),
                            ),
        ),
        "index" => array(
            "blacklist"=>array("ordem","status")
        ),
    );
}
