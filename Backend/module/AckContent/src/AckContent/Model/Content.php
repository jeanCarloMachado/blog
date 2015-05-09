<?php

namespace AckContent\Model;
use AckDb\ZF1\RowAbstract;
class Content extends RowAbstract
{
    protected $_table = "\AckContent\Model\Contents";

    public function isChecked($controllerName)
    {
        if(!($this->getId()->getBruteVal()))

            return false;

        $model = new \AckContent\Model\ContentControllers;

        $where = array("controller" => $controllerName,"conteudo_id"=>$this->getId()->getBruteVal());

        $result = $model->get($where);

        return (empty($result)) ? false : true;
    }
}
