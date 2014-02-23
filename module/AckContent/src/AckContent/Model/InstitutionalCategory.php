<?php
namespace AckContent\Model;
use AckDb\ZF1\RowAbstract;
class InstitutionalCategory extends RowAbstract
{
    protected $_table = "\AckContent\Model\InstitutionalCategorys";

    /**
     * retorna os insitutionais relacionados com
     * esta categoria
     * @param  array  $where [description]
     * @return [type] [description]
     */
    public function getMyInstitutionals($where = array())
    {
        if(!$this->getId()->getBruteVal())

            return array();

        $where["categoria_id"] = $this->getId()->getBruteVal();
        $modelInstitutional = new \AckContent\Model\Institutionals;
        $result = $modelInstitutional->toObject()->onlyAvailable()->get($where);

        return $result;
    }
}
