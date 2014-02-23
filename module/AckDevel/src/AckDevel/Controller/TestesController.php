<?php
namespace AckDevel\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class TestesController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckDevel\Model\Testes");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Teste";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );

}
