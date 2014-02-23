<?php
namespace AckUsers\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract as Controller;
class PermissoesdegruposController extends Controller
{
    protected $models = array("default"=>"\AckUsers\Model\GroupPermissions");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Permissões de grupo";

    protected $config = array (

        "global" => array(
            //"columnSpacing" => 230,
            "showId" => true,
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","titulopt","descricaopt","visivel")
        )
    );
}
