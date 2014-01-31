<?php
namespace AckUsers\Model;
use AckDb\ZF1\RowAbstract;
class Permission extends RowAbstract
{
    protected $_table = "\AckUsers\Model\Permissions";

    public function getRelatedUserObject()
    {
        $model = new \AckUsers\Model\Users();
        $result = $model->toObject()->get(array("id"=>$this->getUsuario()->getBruteVal()));

        $result = reset($result);

        if(empty($result))
            $result = new \AckUsers\Model\User();

        return $result;
    }
}
