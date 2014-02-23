<?php
namespace AckProducts\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class ServicosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckProducts\Model\Services");
    protected $title = "Serviço";
    protected $config = array (
        "global" => array(
            "blacklist"=>array("id","ordem","status","visivel"),
            "elementsSettings" => array(
                            #"titulo_pt" => array("columnSpacing" => 200),
                            "conteudo_pt" => array("columnSpacing" => 500,"type"=>"TextEditor"),
                            "visivel" => array("columnSpacing" => 100),
                            "ordem"=> array("orderSelector" => true,"columnSpacing"=>80)
                        ),
        ),
        "index" => array(
            "whitelist" => array("id","titulo_pt","conteudo_pt","ordem","visivel"),
        ),
        "editar"=> array(
                    "plugins"=>true,
                    "multiplasImagens"=>true,
                    "tamanhoCrop"=>"500 400",
                    "abaImagens"=>true,
                    "abaVideos"=>true,
                    "abaAnexos"=>true
                ),
    );
}
