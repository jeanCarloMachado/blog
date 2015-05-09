<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract;
class Faqs extends TableAbstract
{
    protected $_name = "ack_faq";
    protected $_row = "\AckContact\Model\Faq";

    const moduleName = "Faq";
    const moduleId = 61;
}
