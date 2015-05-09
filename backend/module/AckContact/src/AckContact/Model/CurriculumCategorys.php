<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract;
class CurriculumCategorys extends TableAbstract
{
    protected $_name = "ack_curriculos_categorias";
    protected $_row = "\AckContact\Model\CurriculumCategory";

    const moduleName = "CurriculumCategory";
    const moduleId = 67;
}
