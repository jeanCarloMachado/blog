<?php
namespace AckDevel\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ScriptsbancoController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckDevel\Model\DatabaseScriptss");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Script";
    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel","usuarioid"),
            "elementsSettings" => array(
                            "script" => array("type" => "TextArea","spacing" => 500),
                            "data" => array("permission" => "+r"),
                            "titulo" => array("permission" => "+r"),
                        ),
            "disableADDREMOVE" => true,
            "disableSave" => true,
            "permission" => "+rw",
        ),
        "index" => array(
            "blacklist"=>array("id","usuarioid","ordem","status","visivel")
        ),
    );

    public function executarScriptAjax()
    {
        $model  = new \AckCore\Model\Generics;
        $result = $model->run($this->bruteAjax["script"]);
        echo json_encode(array("status"=>1,"resultado"=> \AckCore\Utils\Arr::implodeRecursively($result), "mensagem"=>"Script rodou com sucesso!"));
    }

    protected function beforeReturn(&$config=null)
    {
        if ($this->params("action") == "editar") {
            $config["footerElements"][]  = \AckCore\HtmlElements\Button::getInstance()->setName('runScript')->setTitle('Executar')->setPermission('+rwx')->setAjaxBlockName('parentDataDispatcher')->setAjaxAction('executarScript');
        }
        if (!empty($config)) {
            \AckCore\Facade::getInstance()->setControllerConfig($config);
        }
    }
}
