<?php
namespace AckCore\Model;
use AckDb\ZF1\RowAbstract;
class Module extends RowAbstract
{
    protected $_table = "\AckCore\Model\Modules";

    public function getUserPermissionLevel($userId = null)
    {
        if(!$this->getId()->getBruteVal())

            return false;

        $where =  array("modulo"=>$this->getId()->getBruteVal());

        if (!$userId) {
            $auth = new \AckUsers\Auth\User();
            $where["usuario"]=$auth->getUserObject()->getId()->getBruteVal();
        } else {
            $where["usuario"]=$userId;
        }

        $result = null;
        {
            $modelPermissions = new \AckUsers\Model\Permissions();
            $result = $modelPermissions->get($where);
            $result = reset($result);
        }

        return $result["nivel"];
    }

    /**
     * retona não sei o que
     * @param  [type] $modulo [description]
     * @return [type] [description]
     */
    public function getAnexosDoModulo($modulo)
    {
        if(empty($modulo))
            throw new \Exception("modulo não foi passado");

        $modelAnexos = new \AckCore\Model\Anexos;

        $where = array("relacao_id"=>'0',"modulo"=>$modulo);

        $anexos = $modelAnexos->toObject()->onlyAvailable()->get($where);

        if(empty($anexos))

            return new \AckCore\Model\Anexo;

        return $anexos;
    }
}
