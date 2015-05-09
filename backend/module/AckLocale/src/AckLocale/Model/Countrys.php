<?php
namespace AckLocale\Model;
use AckDb\ZF1\TableAbstract;
class Countrys extends TableAbstract
{
    protected $_name = "ack_pais";
    protected $_row = "\AckLocale\Model\Country";

    const moduleName = "Country";
    const moduleId = 59;
}
