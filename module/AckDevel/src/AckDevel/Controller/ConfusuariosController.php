<?php
namespace AckDevel\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ConfusuariosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckDevel\Model\SettingsUsers");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Configurações de usuário";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );
}
