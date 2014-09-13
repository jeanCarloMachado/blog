<?php
namespace AckAgenda\Model;
use AckDb\ZF1\TableAbstract as Table;
class Dailys extends Table
{
    protected $relations = array();
    protected $meta = array(
        "humanizedIdentifier" => "conteudo",
   );
    protected $colsNicks = array("autor_id" => "Autor
", "conteudo" => "Conteúdo
", "data" => "Data
");
    
    
    protected $_name = "devil_diario";
    protected $_row = "\AckAgenda\Model\Daily";

    const moduleName = "Daily";
    const moduleId = 69;

    
}








