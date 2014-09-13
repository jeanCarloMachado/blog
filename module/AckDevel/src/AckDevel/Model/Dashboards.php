<?php
namespace AckDevel\Model;
use AckDb\ZF1\TableAbstract;
class Dashboards extends TableAbstract
{
    protected $_name = "ack_sistema";
    protected $_row = "\AckDevel\Model\Dashboard";

    const moduleName = "DeveloperDashbard";
    const moduleId = 44;
}
