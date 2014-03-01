<?php
namespace AckContact\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ContatoscategoriasController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckContact\Model\ContactsCategorys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Categoria de contatos";
    protected $config = array (

        "global" => array(
            "enableId"=>true,
            "blacklist"=>array("id","ordem","status","visivel"),
            "elementsSettings" => array(
                            "descricao" => array("type" => "TextEditor"),
                            "nome" => array("columnSpacing" => 750),
                        ),
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","nome","visivel")
        )
    );
}
