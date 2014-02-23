<?php
namespace AckCore\Model;
use AckDb\ZF1\TableAbstract;
class Generics extends TableAbstract
{
    protected $_name = "app_states";
    protected $_row = "\AckCore\Model\Generic";

    const moduleName = "Generic";
    const moduleId = 47;
}
