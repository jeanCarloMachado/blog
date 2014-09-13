<?php
namespace AckContent\Model;
use AckDb\ZF1\TableAbstract;
class Institutionals extends TableAbstract
{
    protected $_name = "ack_institucional";
    protected $_row = "AckContent\Model\Institutional";

    const moduleName = "institucional";
    const moduleId = 7;

    const DEFAULT_ID = 1;

    protected $colsNicks = array(
                    "titulo_pt" => "Título",
                    "conteudo_pt" => "Conteúdo",
                    "visivel" => "Visível",
                );
}
