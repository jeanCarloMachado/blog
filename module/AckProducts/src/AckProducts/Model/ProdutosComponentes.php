<?php
namespace AckProducts\Model;
use AckDb\ZF1\TableAbstract;
class ProdutosComponentes extends TableAbstract
{
    protected $_name = "ack_produtos_componentes";
    protected $_row = "\AckProducts\Model\ProdutosComponente";

    const moduleName = "ProdutosComponente";
    const moduleId = 48;
}
