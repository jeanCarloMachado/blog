<?php
namespace AckUsers\Model;
use AckDb\ZF1\TableAbstract as Table;
class UsuarioConfiguracoes extends Table
{
    protected $_name = "ack_usuario_configuracao";
    protected $_row = "\AckUsers\Model\UsuarioConfiguracao";

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "visivel"=>"Visível",
    );
}
