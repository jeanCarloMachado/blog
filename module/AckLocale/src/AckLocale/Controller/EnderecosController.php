<?php
namespace AckLocale\Controller;
use  AckMvc\Controller\TableRowAutomatorAbstract;
class EnderecosController extends TableRowAutomatorAbstract
{
    protected $models = array("default"=>"AckLocale\Model\Addresses");
    protected $title = "Endereço";
    protected $config = array(
        "global" => array(
            "elementsSettings" => array(
                "fonept" => array("columnSpacing"=> 200),
                "linkmapapt"=>array("type"=>"TextArea"),
                "emailpt"=>array("columnSpacing"=> 200)
            ),
            "blacklist"=>array("mapapt",/*"linkmapapt"*/),
            "disableADDREMOVE" => true,
        ),
        "index" => array(
            "whitelist" => array(
                "id",
                "nomept",
                "fonept",
                "emailpt",
                "visivel"
            ),
            "addButtonTitle" => "Adicionar endereço",
            "rmButtonTitle" => "Excluir endereços",
        )
    );
}
