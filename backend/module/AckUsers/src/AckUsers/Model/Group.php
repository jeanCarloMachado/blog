<?php
namespace AckUsers\Model;
use AckDb\Model\RowHierarchy;
class Group extends RowHierarchy
{
    protected $_table = "\AckUsers\Model\Groups";
    const GROUP_ADMIN = 1;
    const GROUP_USER_ACK = 4;
    const GROUP_FIRM = 2;
    const GROUP_FIRM_WORKER = 3;

    /**
     * retorna os grupos filhos deste grupo r
     * @return [type] [description]
     */
    public function getMyChildGroups()
    {
        $modelGroupsHierarchys = new \AckUsers\Model\GroupsHierarchys;
        $GroupsHierarchys = $modelGroupsHierarchys->toObject()->get(array("master_id"=>$this->getId()->getBruteVal()));

        return $GroupsHierarchys;
    }
}
