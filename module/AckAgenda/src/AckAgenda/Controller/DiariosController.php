<?php
namespace AckAgenda\Controller;
use System\Mvc\Controller\TableRowAutomatorAbstract as Controller;
class DiariosController extends Controller
{
    protected $models = array("default"=>"\AckAgenda\Model\Dailys");
    protected $title = "Diarios";
    protected $config = array (
        "global" => array(
            //"columnSpacing" => 230,
            "showId" => true,
            "elementsSettings"=>array(
                                        "data"=>array("permission"=>"r","type"=>"Input"),
                                    ),
            "blacklist"=>array("id","ordem","status","visivel",)
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","data","visivel"),
        )
    );
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

     /**
     * função depreciada
     * @param  [type] $config [description]
     * @return [type] [description]
     */
    protected function getCategoryData(&$config)
    {
        if ($this->params("action") == "editar") {
            $config["row"]->setConteudo(\System\Object\Encryption::decode($config["row"]->getConteudo()->getBruteVal()));
        }
    }

    /**
     * executado depois de salvar os dados principais
     * @param resultado do salvamento principal $result
     */
    protected function beforeMainSave()
    {
        $this->ajax["diarios"]["data"] = \System\Object\Date::now();
        $this->ajax["diarios"]["conteudo"]  = \System\Object\Encryption::encode($this->ajax["diarios"]["conteudo"]);
        $this->ajax["diarios"]["autor_id"]  = \AAckCore\Facade::getCurrentUser()->getId()->getBruteVal();
    }
}
