<?php
namespace AckUsers\Model;
use AckDb\Model\TableHierarchy;
class Groups extends TableHierarchy
{
    protected $_name = "ack_usuarios_grupos";
    protected $_row = "\AckUsers\Model\Group";

    const moduleName = "Group";
    const moduleId = 61;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
