<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract as Table;
class Emails extends Table
{
    protected $meta = array(
        "humanizedIdentifier" => "nome",
   );
    protected $colsNicks = array("classe" => "Classe
", "nome" => "Nome
", "descricao" => "Descrição
");
    
    
    
    
    
    protected $_name = "ack_email";
    protected $_row = "\AckContact\Model\Email";

    const moduleName = "Email";
    const moduleId = 42;
}











