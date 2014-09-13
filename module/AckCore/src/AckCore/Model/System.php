<?php
namespace AckCore\Model;
use AckDb\ZF1\RowAbstract;
class System extends RowAbstract
{
    protected $_table = "\AckCore\Model\Systems";
    const DEFAULT_SYSTEM_ID = 1;
    /**
     * retorna o máximo de itens que o sistema suporta em cada carregar mais
     * @return [type] [description]
     */
    public static function maxItens()
    {
        $row = new System;
        $modelName = $row->getTableModelName();
        $model = new $modelName;
        $tableName = $model->getName();
        $result = $model->run("SELECT itens_pagina FROM $tableName WHERE id = ".self::DEFAULT_SYSTEM_ID);
        $result = reset($result);

        return $result['itens_pagina'];
    }

    public function getEmail()
    {
        $address = \AckLocale\Model\Addresses::getFirst();

        return $address->getEmail();
    }

    public static function getDefaultEmail()
    {
        $system = \AckCore\Model\Systems::getFromId(self::DEFAULT_SYSTEM_ID);

        return $system->getEmail()->getBruteVal();
    }
}
