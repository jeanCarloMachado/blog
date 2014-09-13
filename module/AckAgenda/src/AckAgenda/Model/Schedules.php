<?php
namespace AckAgenda\Model;
use AckDb\ZF1\TableAbstract as Table;
class Schedules extends Table
{
    protected $_name = "ack_agendamento";
    protected $_row = "\AckAgenda\Model\Schedule";

    const moduleName = "Schedule";
    const moduleId = 89;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
