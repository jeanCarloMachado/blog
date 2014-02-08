<?php
namespace AckUsers\Access\Observer;
use AckCore\Interfaces\Core\Observer;
class Access implements Observer
{
    const INCREMENT_HOURS_DELAY = 12;

    /**
     *	escuta o notify de um objeto do tipo observer e trata-o a sua maneira
     */
    public function listen(\AckCore\Event $event)
    {
        $resultModel = null;

        if(!($event instanceof \AckCore\Event))
            throw new \Exception(" event não é uma intância de dbinfo");

        if($event->getType() != \AckCore\Event::TYPE_ACCESS_REQUEST)

            return false;

        $where = array();
        $where["ip"] = $_SERVER['REMOTE_ADDR'];

        $obj = new \AckCore\Model\Visits;

        $myLastAccess = ($obj->get($where,array('order'=>'data DESC','limit'=>array('count'=>1))));

        if(!empty($myLastAccess[0]))
            $myLastTime = (strtotime($myLastAccess[0]['data']));
        else
            $myLastTime = 0;
        /**
         * se a hora atual for maior que a última+12 então reincrementa
         * os acessos para aquele ip
         */

        if (((int) $myLastTime+(self::INCREMENT_HOURS_DELAY * 3600) < (int) strtotime(date(\AckCore\Object\Date::getDefaultDateTimeFormat())))) {

            $where["data"] = date(\AckCore\Object\Date::getDefaultDateTimeFormat());
            $obj->create($where);
        }

        return $resultModel;
    }
}
