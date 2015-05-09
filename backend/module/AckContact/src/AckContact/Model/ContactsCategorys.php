<?php
namespace AckContact\Model;
use AckDb\ZF1\TableAbstract;
class ContactsCategorys extends TableAbstract
{
    protected $_name = "ack_contatos_categorias";
    protected $_row = "\AckContact\Model\ContactsCategory";

    const moduleName = "ContactsCategory";
    const moduleId = 64;
}
