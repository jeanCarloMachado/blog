<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract as Table;
class Vacancys extends Table
{
    protected $_name = "ack_vagas";
    protected $_row = "\AckContact\Model\Vacancy";

    const moduleName = "Vacancy";
    const moduleId = 87;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
