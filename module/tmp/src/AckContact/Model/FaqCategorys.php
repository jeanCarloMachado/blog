<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract;
class FaqCategorys extends TableAbstract
{
    protected $_name = "ack_faq_categorias";
    protected $_row = "\AckContact\Model\FaqCategory";

    const moduleName = "FaqCategory";
    const moduleId = 60;

}
