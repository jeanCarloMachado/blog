<?php
namespace AckCore\Log\Observer;
use AckCore\Interfaces\Core\Observer;
class DbLog implements Observer
{
    /**
     *	escuta o notify de um objeto do tipo observer e trata-o a sua maneira
     */
    public function listen(\AckCore\Event $event)
    {
        if(!($event instanceof \AckCore\Event))
            throw new \Exception(" event não é uma intância de dbinfo");

        $user = \AckCore\Facade::getCurrentUser();

        $resultModel = null;
        $model = new \AckCore\Model\Logs;
        $result = $event->getResult();
        $result  = is_array($result) ? $result : array($result);
        foreach ($event->getResult() as $id) {

            $where = array(
                    "data"=>date(\AckCore\Utils\Date::getDefaultDateTimeFormat()),
                    "usuario"=>$user->getId()->getBruteVal(),
                    "acao"=>$event->getAction(),
                    "tabela"=>$event->getTable(),
                    "id_afetado"=> ($id) ? $id : 666,
                    "texto_log"=> "nao implementado aidna",
                    "instrucao_sql"=>$event->getQuery()
            );
            $resultModel = $model->create($where);
        }

        return $resultModel;
    }
}
