<?php
namespace AckContent\Model;
use AckDb\ZF1\TableAbstract;
class Contents extends TableAbstract
{
    protected $_name = "ack_conteudos";
    protected $_row = "\AckContent\Model\Content";

    const moduleName = "conteudos";
    const moduleId = 33;

    protected $colsNicks = array(
        "fakeid" => "Id",
        "visivel"=>"Visível",
        "titulo"=>"Título do conteúdo",
        "descricao"=>"Descrição do conteúdo",
        "front" => "Site",
        "conteudo_ajuda"=> "Conteúdo de ajuda",
        "titulo_ajuda"=> "Título de ajuda",
        "negocio" => "Específico de negócio",
        "front" => "Conteúdo do site"

    );
}
