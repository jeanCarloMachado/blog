<?php
namespace AckContact\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class CurriculoscategoriasController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"\AckContact\Model\CurriculumCategorys");
    /**
     * colocar no singlular
     * @type {String}
     */
    protected $title = "Categoria de currículos";

    protected $config = array (

        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel"),
            "elementsSettings" => array("descricao" => array("type"=>"TextEditor","orderSelector" => true)),
        ),
        "index" => array(
            "blacklist"=>array("ordem","status","visivel")
        )
    );
}
