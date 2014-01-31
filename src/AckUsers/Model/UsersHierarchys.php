<?php
namespace AckUsers\Model;
use AckDb\ZF1\TableAbstract as Table;
class UsersHierarchys extends Table
{
    protected $_name = "ack_usuarios_hierarquia";
    protected $_row = "\AckUsers\Model\UsersHierarchy";

    const moduleName = "UsersHierarchy";
    const moduleId = 63;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
