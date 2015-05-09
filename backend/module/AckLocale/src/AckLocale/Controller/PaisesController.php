<?php
namespace AckLocale\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class PaisesController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckLocale\Model\Countrys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Paise";
    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );
}
