<?php
namespace AckDevel\Model;
use AckDb\ZF1\FakeTableAbstract;
class DatabaseScriptss extends FakeTableAbstract
{
    protected $_name = "ack_database_scripts";
    protected $_row = "\AckDevel\Model\DatabaseScripts";

    const moduleName = "DatabaseScripts";
    const moduleId = 45;

    protected $rows = array(
        array(
        "id" => 2, "visivel" => 1, "status" => 1, "data" => "01/07/2013","titulo"=> "Teste Script",
            "script" => "ALTER TABLE `ack_tests` ADD `descricao` VARCHAR( 255 ) NOT NULL AFTER `titulo` "
        )
    );

    protected $colsNicks = array(
        "titulo" => "Título",
    );

    protected $schema = array(
        array(
            "Field" => "id",
            "Type" => "int(11)",
            "Null" => "NO",
            "Key" => "PRI",
            "Default" => "",
            "Extra" => "auto_increment",
        ),
        array(
            "Field" => "titulo",
            "Type" => "text",
            "Null" => "NO",
            "Key" => "",
            "Default" => "",
            "Extra" => "",
        ),
        array(
            "Field" => "data",
            "Type" => "text",
            "Null" => "NO",
            "Key" => "",
            "Default" => "",
            "Extra" => "",
        ),
        array(
            "Field" => "script",
            "Type" => "text",
            "Null" => "NO",
            "Key" => "",
            "Default" => "",
            "Extra" => "",
        ),
        array(
            "Field" => "status",
            "Type" => "tinyint(4)",
            "Null" => "NO",
            "Key" => "",
            "Default" => "1",
            "Extra" => "",
        ),
    );
}
