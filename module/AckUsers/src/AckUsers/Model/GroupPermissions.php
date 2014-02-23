<?php
namespace AckUsers\Model;
use AckDb\ZF1\TableAbstract as Table;
class GroupPermissions extends Table
{
    protected $_name = "ack_usuarios_grupos_permissoes";
    protected $_row = "\AckUsers\Model\GroupPermission";

    const moduleName = "GroupPermission";
    const moduleId = 67;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
