<?php
namespace AckAgenda\Model;
use AckDb\ZF1\RowAbstract;
class Task extends RowAbstract
{
    protected $_table = "\AckAgenda\Model\Tasks";

    public function getMyFrequency()
    {
        return $this->seekMyFirstFrequencys("frequencia_id","\AckAgenda\Model\\");
    }

    public function setResponsavelAtualId($id)
    {
        if(empty($id))
            $id = \Ack\Model\Tasks::DEFAULT_USER_ID;

        $this->setVar("responsavelatualid",$id);

        return $this;
    }

    public function getResponsavelAtualId()
    {
        $id = $this->getVar("responsavelatualid");

        if(!($id->getBruteVal()))
            $id->bruteValue = \AckAgenda\Model\Tasks::DEFAULT_USER_ID;

        return $id;
    }

    public function switchState()
    {
        $modelTasksHistorys = new \AckAgenda\Model\TasksHistorys;

        $user = \AckUsers\Model\Users::getFromId( $this->getresponsavelatualid()->getBruteVal());
        $user = $user->getNext();

        $frequencyId = $this->getFrequenciaId()->getBruteVal();
        //calcula a diferença com a frequència
        $frequency = \AckAgenda\Model\Frequencys::getFromId($frequencyId);

        $newOrder = $this->getOrdem()->getBruteVal();
        $visivelVal = $this->getVisivel()->getBruteVal();

        if (!$visivelVal) {
            $newOrder = \AckAgenda\Model\Tasks::getInstance()->getMinorOrderObject()->getOrdem()->getBruteVal();
            $newOrder--;
            $visivelVal = 1;
        } else {
            $visivelVal = 0;
        }

        $status = $this->setResponsavelAtualId($user->getId()->getBruteVal())
                ->setDataUltimaRealizacao(\System\Object\Date::now())
                ->setdataexpiracao(\System\Object\Date::daysFromNow($frequency->getQuantidadeDias()->getBruteVal()))
                ->setVisivel($visivelVal)->setOrdem($newOrder)->save();

        $set["tarefa_id"]  = $this->getId()->getBruteVal();
        $set["usuario_id"] = $this->getresponsavelatualid()->getBruteVal();
        $auth = new \AckUsers\Auth\User;
        $user = $auth->getUser();
        $set["usuario_concluinte_id"] = $user["id"];
        $set["data"] = \System\Object\Date::now();
        $modelTasksHistorys->create($set);

        return true;
    }
}
