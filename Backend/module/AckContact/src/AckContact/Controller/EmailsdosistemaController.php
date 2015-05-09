<?php
namespace AckContact\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract as Controller;
use \AckUsers\Model\User,
AckCore\Legacy\Ack52Layer,
\AckCore\Event, \AckCore\Facade, \AckCore\Model\Languages, \AckCore\DataAbstraction\Service\InterpreterSearch;
class EmailsdosistemaController extends Controller
{
    /**
     * estas classes implementam o design pattern observer,
     * servindo para prover recursos em momentos que o controlador
     * notifica aos observadores quando algo importante ocorreu
     * @var array
     */
    protected $observers = array(
                    "\AckMvc\Controller\Observer\Authenticator",
                    "\AckMvc\Controller\Observer\FacadeSyncer",
                    "\AckCore\Observer\MetatagsManager",
                    //observer de àrea restrita para administradores
                    "\AckUsers\Observer\AdminPermissionTester",
    );

    protected $models = array("default"=>"\AckContact\Model\Emails");
    protected $title = "E-mails do sistema";
    protected $config = array (
        "global" => array(
            //"columnSpacing" => 230,
            "showId" => true,
            //"disableADDREMOVE" => true,
            "elementsSettings"=>array(
                "fakeid"=>array("columnSpacing"=>80),
                "ordem"=>array("orderSelector" => true,"columnSpacing"=>80)
            ),
            "blacklist"=>array("id","ordem","status","visivel"),
            "disableTitlePluralizer" => true,
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","nome","ordem","visivel")
        )
    );

    public function getCategoryData(&$config)
    {
            if ($this->params("action") == "editar") {
                $row =& $config["row"];
                $config["toRenderCOL2"][] = \AckCore\HtmlElements\Link::getInstance()->setPermission("+r")->setName("visualizar")->setTitle("Visualizar")->setUrl("/ack/emailsdosistema/visualizar/".$row->getId()->getBruteVal());;
            }
    }

    public function visualizarAction()
    {
        $id = ($this->params('id'));

        $email = \AckContact\Model\Emails::getFromId($id);
        $className = $email->getClasse()->getVal();
        $classInstance =  new $className;
        $classInstance->enableSimulation()->render();

        return $this->response;
    }
}
