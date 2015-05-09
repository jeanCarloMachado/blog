<?php
namespace AckContent\Controller;
use AckMvc\Controller\TableRowAutomatorAbstract;
class DestaquesController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckContent\Model\Highlights");
    protected $title = "Destaque";
    protected $config = array(
        "editar"=> array("plugins"=>true,
            "multiplasImagens"=>false,
            "tamanhoCrop"=>"1280 640",
            "abaImagens"=>true,
            "abaVideos"=>false,
            "abaAnexos"=>false,
            "blacklist" => array("modulo"),
            ),
        "index" => array(
            "whitelist" => array("id","fakeid","titulopt","descricaopt","ordem","visivel")

        ),
        "carregar_mais"=>array(
                        "returnFalseInCols"=>array("status","visivel")
                    ),
        "global"=>array(
            "showId"=> true,
            "blacklist"=>array("id","modulo","status","visivel","ordem","titulo"),
            "elementsSettings" => array(
                "urlpt"=> array("orderSelector" => true),
                "descricaopt" => array("columnSpacing" => 400,"type"=>"TextEditor"),
                "fakeid"=>array("columnSpacing"=>80),
                "ordem"=> array("orderSelector" => true,"columnSpacing"=>80),
                /**
                 * denifições das configurações
                 */
                "definitions" => array(
                    "names" => array(
                        "/url/" => array("renderFilter"=>false),
                    ),
                )
           ),
            "disableImageCover" => true,
        ),
    );
}
