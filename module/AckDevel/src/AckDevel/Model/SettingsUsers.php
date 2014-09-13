<?php
namespace AckDevel\Model;
use AckDb\ZF1\TableAbstract;
class SettingsUsers extends TableAbstract
{
    protected $_name = "ack_user_settings";
    protected $_row = "\AckDevel\Model\SettingsUser";

    const moduleName = "SettingsUser";
    const moduleId = 49;
}
