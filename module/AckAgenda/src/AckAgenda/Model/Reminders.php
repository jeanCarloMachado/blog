<?php
namespace AckAgenda\Model;
use AckDb\ZF1\TableAbstract as Table;
class Reminders extends Table
{
    protected $_name = "devil_lembrete";
    protected $_row = "\AckAgenda\Model\Reminder";

    const moduleName = "Reminder";
    const moduleId = 101;

    protected $colsNicks = array(
        "fakeid"=>"Id",
        "visivel"=>"Visível",
    );
}
