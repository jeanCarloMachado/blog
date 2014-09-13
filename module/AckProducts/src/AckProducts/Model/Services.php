<?php
namespace AckProducts\Model;
use AckDb\ZF1\TableAbstract;
class Services extends TableAbstract
{
    protected $_name = "ack_servicos";
    protected $_row = "\AckProducts\Model\Service";
    const DEFAULT_ID = 1;
    const moduleName = "servicos";
    const moduleId = 9;
    protected $colsNicks = array(
        "titulo_pt" => "Título",
        "visivel" => "Visível",
        "conteudo_pt" => "Conteúdo",
    );
}
