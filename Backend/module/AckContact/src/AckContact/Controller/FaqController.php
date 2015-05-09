<?php
namespace AckContact\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class FaqController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckContact\Model\Faqs");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Faq";
    protected $config = array (
        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel",'categoriaid',"acessos","positivos","negativos"),
            "elementsSettings" => array(
                            "positivos" => array("permission"=>"+r",),
                            "negativos" => array("permission" => "+r"),
                            "acessos" => array("permission" => "+r"),
                            "resposta" => array("type" => "TextEditor"),
                            "pergunta" => array("type" => "TextEditor"),
                        ),
            "colB" => array(
                        "whitelist"=>array("acessos","positivos","negativos")
                    ),
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );
    public function getCategoryData(&$config)
    {
            if ($this->params("action") == "editar" || $this->params("action") == "incluir") {
                $modelFaqCategorys = new \AckContact\Model\FaqCategorys;
                $config["FaqCategorys"] = $modelFaqCategorys->toObject()->onlyAvailable()->get();
            }
    }
}
