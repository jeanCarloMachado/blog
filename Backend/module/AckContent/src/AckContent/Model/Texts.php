<?php
namespace AckContent\Model;
use AckDb\ZF1\TableAbstract;
class Texts extends TableAbstract
{
    protected $_name = "ack_textos";
    protected $_row = "AckContent\Model\Text";
    //tem o mesmo id que o módulo de sistemas
    //pois não encontrei nenhum módulo de textos
    const moduleName = "textos";
    const moduleId = 32;

    const TYPE_MAIN_LIST = 1;
    const TYPE_LIST = 2;
    const TYPE_MAIN_DETAIL = 3;
    const TYPE_CONTENT_DETAIL = 4;

    //tipos de textos default que o ack contém
    protected static $types = array(

                                1 => array("name" => "Principal página de listagem"),
                                2 => array("name" => "Descritivo de lista"),
                                3 => array("name" => "Principal página detalhada"),
                                4 => array("name" => "Conteúdo página detalhada")
                                );
}
