<?php
namespace AckContact\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class CategoriasfaqController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckContact\Model\FaqCategorys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Faq categoria";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel"),
            "elementsSettings" => array("nome"=>array("orderSelector"=>true)),
        ),
        "index" => array(

            "blacklist"=>array("ordem","status","visivel")
        )
    );
}
