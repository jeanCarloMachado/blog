<?php
namespace AckLocale\Model;

use AckDb\ZF1\RowAbstract;
use AckCore\Vars\Variable;

class City extends RowAbstract
{
    protected $_table = "\AckLocale\Model\Cities";

    public function getMyState()
    {
        //pega o valor aproriado (caso a relacao esteja vazia, retorna um elemento de relação vazio)
        if (!$this->getEstadoId()->getBruteVal()) {
            return $this->getServiceLocator()->get('States')->getRowPrototype();
        }

        return $this->getServiceLocator()->get('States')->toObject()->getOne(array('id'=>$this->getEstadoId()->getBruteVal()));
    }

    public function getCidadeUf()
    {
        $result = new Variable;

        $value = $this->getNome()->getBruteVal().'/'.$this->getMyState()->getSigla()->getBruteVal();

        $result->setBruteVal($value);

        return $result;
    }
}
