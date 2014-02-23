<?php
namespace AckDevel\Model;
use AckDb\ZF1\TableAbstract;
class Testes extends TableAbstract
{
    protected $_name = "ack_tests";
    protected $_row = "\AckDevel\Model\Teste";

    const moduleName = "Teste";
    const moduleId = 46;
}
