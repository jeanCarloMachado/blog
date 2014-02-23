<?php
namespace AckLocale\Controller;

use AckMvc\Controller\AbstractTableRowController;

class EstadosController extends AbstractTableRowController
{
    protected $models = array("default"=>"\AckLocale\Model\Estados");
    protected $config = array (
        "global" => array(
            //"columnSpacing" => 230,
            "showId" => true,
            "elementsSettings"=>array("nome"=>array("columnSpacing"=>600,"orderSelector"=>true)),
            "blacklist"=>array("id","ordem","status","visivel")
        ),
        "index" => array(
            "whitelist"=>array("id","fakeid","nome","visivel")
        )
    );
}
