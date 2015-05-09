<?php
namespace AckContact\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ContatosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckContact\Model\Contacts");
    protected $title = "Contato";

    protected $config = array(

            "global" => array(
                "permission" => "+r",
                "disableAdd" => true,
                 "elementsSettings" => array(
                    "fakeid" => array("columnSpacing"=> 80),
                    "data" => array("columnSpacing"=> 120),
                    "email"=>array("columnSpacing"=> 200)
                ),
            ),
            "editar" => array(
                "disableLayout" => true,
                "blacklist" => array(
                    "id",
                    "status",
                    "lido",
                    "setor",
                    "sexo",
                    "cep",
                    "estado",
                    "cidade",
                    "bairro",
                    "endereco",
                    "empresa",
                ),
                "elementsSettings" => array(
                    "mensagem" => array("type" => "TextArea"),
                    "lido" => array("type" => "BooleanSelector", "permission" => "+rw"),
                ),
                "colB" => array(
                    "whitelist" => array("lido")
                )
            ),
            "index" => array(
                "whitelist" => array(
                    "id",
                    "fakeid",
                    "email",
                    "mensagem",
                    "data",
                ),
                "filters_file" => "filters.phtml",
                "rmButtonTitle" => "Excluir Contatos",
            ),
        );

    public function loadMoreOnColumnIterator(&$key, &$element, &$iterator, array &$bdColumns, array &$result, array &$config)
    {
        if ($key == "id") {
            if(isset($config["showId"]) && $config["showId"] == true)
            $result["grupo"][$iterator]["fakeid"] = $element->getVal();
        } elseif ($key == "lido") {
            $result["grupo"][$iterator]["bold"] = ($element->getVal()) ? 1 : 0;
        }
    }

   /**
     * pega os dados das categorias pra mandar para a renderização
     * @param unknown $config
     */
    protected function afterGetMainRow(&$config)
    {
        if ($this->params("action") == "editar") {
            //pega os nomes dos controladores e manda para o select
            $contact = \AckContact\Model\Contacts::getFromId($this->params("id"));
            if ($contact && !$contact->getLido()->getBruteVal()) {
                $contact->setLido(1)->save();
            }

            $config["row"]->vars["data"]->setValue(\AckCore\Utils\Date::fromMysql($config["row"]->getData()->getBruteVal(),"/",true));

        }
    }
}
