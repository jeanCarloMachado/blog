<?php
namespace AckLocale\Model;
use AckDb\ZF1\RowAbstract;
class State extends RowAbstract
{
    protected $_table = "\AckLocale\Model\States";

    public function getMyCities()
    {
        return $this->seekMyCitys("estado_id","\AckLocale\Model\\");
    }
}
