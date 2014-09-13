<?php
namespace AckAgenda\Model;
use AckDb\ZF1\TableAbstract as Table;
class Frequencys extends Table
{
    protected $meta = array(
        "humanizedIdentifier" => "nome",
   );
    protected $colsNicks = array("nome" => "Nome
", "quantidade_dias" => "Quantidade de dias
");
    
    
    protected $_name = "ack_frequencias";
    protected $_row = "\AckAgenda\Model\Frequency";

    const moduleName = "Frequency";
    const moduleId = 50;

}





