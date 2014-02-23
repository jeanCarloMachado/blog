<?php
namespace AckLocale\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class CidadesController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckLocale\Model\Citys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Cidade";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );

}
