<?php

namespace SiteJean\Db;

use AckDb\ZF1\TableAbstract as AckTableAbstract;
class TableAbstract extends AckTableAbstract
{

    public function get(array $where=null,$params=null,$columns=null)
    {
        //adiciona a empresa ao filtro caso seja um usuário de alguma
        if ($this->getServiceLocator()->get('Auth')->hasIdentity()) {
            $user =  $this->getServiceLocator()->get('Auth')->getIdentity();

            if ((!isset($where['filial_id'])
                || empty($set['filial_id']))
                && $user->getFilialId()->getBruteVal()) {
                $where['filial_id'] = $user->getFilialId()->getBruteVal();
            }
        }

        return parent::get($where, $params, $columns);
    }

    public function create(array $set,array $params=null)
    {
        //adiciona a empresa ao filtro caso seja um usuário de alguma
        if ($this->getServiceLocator()->get('Auth')->hasIdentity()) {
            $user =  $this->getServiceLocator()->get('Auth')->getIdentity();

            if ((!isset($set['filial_id']) || empty($set['filial_id'])) && $user->getFilialId()->getBruteVal()) {
                $set['filial_id'] = $user->getFilialId()->getBruteVal();
            }
        }

        return parent::create($set, $params);
    }
}
