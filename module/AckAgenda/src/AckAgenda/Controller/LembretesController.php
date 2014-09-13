<?php
namespace AckAgenda\Controller;
use System\Mvc\Controller\TableRowAutomatorAbstract as Controller;
class LembretesController extends Controller
{
    protected $models = array("default"=>"\AckAgenda\Model\Reminders");
    protected $title = "Lembretes";
    /**
     * estas classes implementam o design pattern observer,
     * servindo para prover recursos em momentos que o controlador
     * notifica aos observadores quando algo importante ocorreu
     * @var array
     */
    protected $observers = array(
                    "\System\Mvc\Controller\Observer\Authenticator",
                    "\System\Mvc\Controller\Observer\FacadeSyncer",
                    "\AAckCore\Observer\MetatagsManager",
                    //adiciona o observer de permissão de usuaŕio devil
                    "\AckUsers\Observer\DevilPermissionTester",
    );
    protected $config = array (
        "global" => array(
            //"columnSpacing" => 230,
            "showId" => true,
            "elementsSettings"=>array("nome"=>array("columnSpacing"=>600,"orderSelector"=>true)),
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","nome","visivel")
        ),
        "editar"=>array(
                    "plugins"=>true,
                    "multiplasImagens"=>true,
                    "tamanhoCrop"=>"511 340",
                    "abaImagens"=>true,
                    "abaVideos"=>true,
                    "abaAnexos"=>true,
                ),
    );
}
