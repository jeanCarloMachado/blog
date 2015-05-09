<?php
namespace AckContent\Model;
use AckDb\ZF1\TableAbstract;
class InstitutionalCategorys extends TableAbstract
{
    protected $_name = "ack_institucional_categorias";
    protected $_row = "\AckContent\Model\InstitutionalCategory";

    const moduleName = "InstitutionalCategory";
    const moduleId = 54;
    const QUEM_SOMOS_ID  = 3;

    protected $colsNicks = array(
        "fakeid"=>"Id"
    );
}
