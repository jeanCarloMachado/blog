<?php
namespace AckCore\Model;
use AckDb\ZF1\RowAbstract;
class Language extends RowAbstract
{
    protected $_table = "\AckCore\Model\Languages";

    public static function isAPtColumn($name)
    {
        if(substr($name, -3,1) == "_" && substr($name, -3) != "_pt")

            return false;
        return true;
    }
}
