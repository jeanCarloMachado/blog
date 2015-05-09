<?php
namespace AckUsers\Model;
use AckDb\ZF1\TableAbstract as Table;
class GroupsHierarchys extends Table
{
    protected $_name = "ack_usuarios_grupos_hierarquia";
    protected $_row = "\AckUsers\Model\GroupsHierarchy";

    const moduleName = "GroupsHierarchy";
    const moduleId = 68;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
